export default function ApplicationLogo(props) {
    return (
        <img 
            src="/real_logo_eProShop-removebg-preview.png" 
            alt="eProShop Logo" 
            {...props}
            className={`object-contain ${props.className || ''}`}
        />
    );
}
