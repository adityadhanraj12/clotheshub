<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UsersAddress;

class CustomerAddressController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            // Invoice Address
            'first_name' => 'required',
            'email' => 'required|email',
            'street' => 'required',
            'city' => 'required',
            'postal_code' => [
                'required',
                'digits:6',
                function ($attribute, $value, $fail) use ($request) {
                    if (!self::validatePincodeForState($request->state, $value)) {
                        $fail('Please enter correct pin code.');
                    }
                }
            ],
            'state' => 'required',
            'phone_number' => 'required|digits:10',

            // Shipping Address
            'shipping_first_name' => 'nullable|required_if:different_shipping,1',
            'shipping_email' => 'nullable|required_if:different_shipping,1|email',
            'shipping_address' => 'nullable|required_if:different_shipping,1',
            'shipping_city' => 'nullable|required_if:different_shipping,1',
            'shipping_zip' => [
                'nullable',
                'required_if:different_shipping,1',
                'digits:6',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->different_shipping && !self::validatePincodeForState($request->shipping_state, $value)) {
                        $fail('Please enter correct pin code.');
                    }
                }
            ],
            'shipping_state' => 'nullable|required_if:different_shipping,1',
            'shipping_phone_number' => 'nullable|required_if:different_shipping,1|digits:10',
        ], [

            // Invoice Address Messages
            'first_name.required' => 'Please enter the recipient\'s first name.',
            'email.required' => 'Please provide a email address.',
            'email.email' => 'Please enter a valid email address.',
            'street.required' => 'Please enter the street address.',
            'city.required' => 'Please enter the city.',
            'postal_code.required' => 'Please enter the postal code.',
            'postal_code.digits' => 'Postal code must be exactly 6 digits.',
            'state.required' => 'Please enter the state.',
            'phone_number.required' => 'Please enter the phone number.',
            'phone_number.digits' => 'Phone number must be exactly 10 digits.',

            // Shipping Address Messages
            'shipping_first_name.required_if' => 'Please enter the recipient\'s first name.',
            'shipping_email.required_if' => 'Please provide a shipping email address.',
            'shipping_email.email' => 'Please enter a valid shipping email address.',
            'shipping_address.required_if' => 'Please enter the shipping street address.',
            'shipping_city.required_if' => 'Please enter the shipping city.',
            'shipping_zip.required_if' => 'Please enter the shipping postal code.',
            'shipping_zip.digits' => 'Shipping postal code must be exactly 6 digits.',
            'shipping_state.required_if' => 'Please enter the shipping state.',
            'shipping_phone_number.required_if' => 'Please enter the shipping phone number.',
            'shipping_phone_number.digits' => 'Shipping phone number must be exactly 10 digits.',
        ]);
        $user = auth()->user();
        UsersAddress::updateOrCreate(
            [
                'user_id' => $user->id,
                'address_type' => 'invoice'
            ],
            [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email_address' => $request->email,
                'street' => $request->street,
                'city' => $request->city,
                'postal_code' => $request->postal_code,
                'state' => $request->state,
                'phone_number' => $request->phone_number,
            ]
        );
        if ($request->different_shipping) {
            UsersAddress::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'address_type' => 'shipping'
                ],
                [
                    'first_name' => $request->shipping_first_name,
                    'last_name' => $request->shipping_last_name,
                    'email_address' => $request->shipping_email,
                    'street' => $request->shipping_address,
                    'city' => $request->shipping_city,
                    'postal_code' => $request->shipping_zip,
                    'state' => $request->shipping_state,
                    'phone_number' => $request->shipping_phone_number,
                ]
            );
        } else {
            UsersAddress::where('user_id', $user->id)
                ->where('address_type', 'shipping')
                ->delete();
        }

        return redirect()
            ->back()
            ->with('success', 'Address saved successfully.');
    }

    private static function validatePincodeForState(?string $state, ?string $pincode): bool
    {
        if (empty($state) || empty($pincode)) {
            return true;
        }
        $pincode = trim($pincode);
        if (strlen($pincode) < 1) {
            return true;
        }
        $firstDigit = $pincode[0];
        switch (strtolower(trim($state))) {
            case 'bihar':
            case 'jharkhand':
                return $firstDigit === '8';
            case 'uttar pradesh':
            case 'uttarakhand':
                return $firstDigit === '2';
            case 'rajasthan':
            case 'gujarat':
                return $firstDigit === '3';
            case 'maharashtra':
            case 'goa':
            case 'madhya pradesh':
            case 'chhattisgarh':
                return $firstDigit === '4';
            case 'andhra pradesh':
            case 'telangana':
            case 'karnataka':
                return $firstDigit === '5';
            case 'tamil nadu':
            case 'kerala':
                return $firstDigit === '6';
            case 'west bengal':
            case 'odisha':
            case 'assam':
            case 'arunachal pradesh':
            case 'manipur':
            case 'meghalaya':
            case 'mizoram':
            case 'nagaland':
            case 'sikkim':
            case 'tripura':
                return $firstDigit === '7';
            case 'delhi':
            case 'haryana':
            case 'punjab':
            case 'chandigarh':
            case 'himachal pradesh':
            case 'jammu & kashmir':
                return $firstDigit === '1';
            default:
                return true;
        }
    }
}