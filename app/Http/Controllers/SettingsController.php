<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Models\Vendor;
use App\Models\User;

class SettingsController extends Controller
{
    /**
     * Display the settings dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $vendor = auth()->user()->vendor;
        return view('vendors.settings.index', compact('vendor'));
    }

    /**
     * Update the vendor's profile information.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:20'],
            'current_password' => ['nullable', 'required_with:new_password', 'current_password'],
            'new_password' => ['nullable', 'min:8', 'confirmed'],
        ]);

        // Update user details
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        
        // Update password if provided
        if (!empty($validated['new_password'])) {
            $user->password = Hash::make($validated['new_password']);
        }
        
        $user->save();

        // Update vendor details
        $vendor = $user->vendor;
        $vendor->phone = $validated['phone'] ?? null;
        $vendor->save();

        return redirect()->route('vendor.settings')
            ->with('success', 'Profile updated successfully.');
    }

    /**
     * Update the vendor's store information.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateStore(Request $request)
    {
        $vendor = auth()->user()->vendor;
        
        $validated = $request->validate([
            'store_name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'address' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:100'],
            'state' => ['required', 'string', 'max:100'],
            'country' => ['required', 'string', 'max:100'],
            'postal_code' => ['required', 'string', 'max:20'],
            'logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('vendor/logos', 'public');
            $validated['logo'] = $path;
        }

        $vendor->update($validated);

        return redirect()->route('vendor.settings')
            ->with('success', 'Store information updated successfully.');
    }

    /**
     * Update the vendor's payment settings.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePaymentSettings(Request $request)
    {
        $vendor = auth()->user()->vendor;
        
        $validated = $request->validate([
            'bank_name' => ['required', 'string', 'max:255'],
            'account_name' => ['required', 'string', 'max:255'],
            'account_number' => ['required', 'string', 'max:50'],
            'routing_number' => ['required', 'string', 'max:50'],
            'swift_code' => ['nullable', 'string', 'max:50'],
            'paypal_email' => ['nullable', 'email', 'max:255'],
        ]);

        $vendor->paymentSettings()->updateOrCreate(
            ['vendor_id' => $vendor->id],
            $validated
        );

        return redirect()->route('vendor.settings')
            ->with('success', 'Payment settings updated successfully.');
    }
}
