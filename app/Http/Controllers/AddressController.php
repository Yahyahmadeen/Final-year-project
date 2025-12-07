<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AddressController extends Controller
{
    /**
     * Display a listing of the user's addresses.
     */
    public function index()
    {
        $addresses = Auth::user()->addresses()->latest()->get();
        return view('addresses.index', compact('addresses'));
    }

    /**
     * Show the form for creating a new address.
     */
    public function create()
    {
        return view('addresses.create');
    }

    /**
     * Store a newly created address in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'company' => 'nullable|string|max:255',
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'is_default' => 'sometimes|boolean',
        ]);

        // If this is the first address, make it default
        if (Auth::user()->addresses()->count() === 0) {
            $validated['is_default'] = true;
        }

        // If setting as default, unset other defaults
        if ($request->is_default) {
            Auth::user()->addresses()->update(['is_default' => false]);
        }

        Auth::user()->addresses()->create($validated);

        return redirect()->route('addresses.index')
            ->with('success', 'Address added successfully.');
    }

    /**
     * Show the form for editing the specified address.
     */
    public function edit(Address $address)
    {
        $this->authorize('update', $address);
        return view('addresses.edit', compact('address'));
    }

    /**
     * Update the specified address in storage.
     */
    public function update(Request $request, Address $address)
    {
        $this->authorize('update', $address);

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'company' => 'nullable|string|max:255',
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'is_default' => 'sometimes|boolean',
        ]);

        // If setting as default, unset other defaults
        if ($request->is_default) {
            Auth::user()->addresses()->where('id', '!=', $address->id)
                ->update(['is_default' => false]);
        }

        $address->update($validated);

        return redirect()->route('addresses.index')
            ->with('success', 'Address updated successfully.');
    }

    /**
     * Remove the specified address from storage.
     */
    public function destroy(Address $address)
    {
        $this->authorize('delete', $address);
        
        // If deleting the default address, set another one as default if available
        if ($address->is_default) {
            $newDefault = Auth::user()->addresses()
                ->where('id', '!=', $address->id)
                ->first();
                
            if ($newDefault) {
                $newDefault->update(['is_default' => true]);
            }
        }

        $address->delete();

        return redirect()->route('addresses.index')
            ->with('success', 'Address deleted successfully.');
    }

    /**
     * Set an address as default.
     */
    public function setDefault(Address $address)
    {
        $this->authorize('update', $address);

        DB::transaction(function () use ($address) {
            Auth::user()->addresses()->update(['is_default' => false]);
            $address->update(['is_default' => true]);
        });

        return back()->with('success', 'Default address updated successfully.');
    }
}
