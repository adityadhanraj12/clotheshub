<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use App\Models\UsersAddress;
use App\Models\Order;
use App\Models\Product;

class RouteController extends Controller
{
    public function index()
    {
        $menProducts = Product::whereHas('collection', function ($q) {
            $q->where('category_id', 1);
        })->take(8)->get();

        $womenProducts = Product::whereHas('collection', function ($q) {
            $q->where('category_id', 2);
        })->take(8)->get();

        return view('index', compact(
            'menProducts',
            'womenProducts'
        ));
    }
    public function category()
    {
        return view('category');
    }

    public function detail()
    {
        return view('detail');
    }
    public function cart()
    {
        return view('cart');
    }
    public function checkout5()
    {
        return view('checkout5');
    }
    public function contact()
    {
        return view('contact');
    }
    public function about()
    {
        return view('about');
    }
    public function faq()
    {
        return view('faq');
    }
    public function customerLogin()
    {
        return view('customer-login');
    }
    public function customerOrders()
    {
        $orders = Order::where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('customer-orders', compact('orders'));
    }
    public function customerAddresses()
    {
        return view('customer-addresses');
    }
    public function customerAccount()
    {
        return view('customer-account');
    }
    public function checkout1()
    {
        $userId = Auth::id();

        $carts = Cart::with('product')
            ->where(function ($q) {
                $q->where('user_id', Auth::id())
                    ->orWhere('session_id', session()->getId());
            })
            ->get();

        $addresses = UsersAddress::where('user_id', $userId)->get();

        return view('checkout1', compact('carts', 'addresses'));
    }
    public function saveAddress(Request $request)
    {
        $request->validate([
            // Invoice Address
            'first_name' => 'required',
            'email_address' => 'required|email',
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
            'shipping_first_name' => 'exclude_unless:different_shipping,1|required',
            'shipping_email' => 'exclude_unless:different_shipping,1|required|email',
            'shipping_address' => 'exclude_unless:different_shipping,1|required',
            'shipping_city' => 'exclude_unless:different_shipping,1|required',
            'shipping_zip' => [
                'exclude_unless:different_shipping,1',
                'required',
                'digits:6',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->different_shipping && !self::validatePincodeForState($request->shipping_state, $value)) {
                        $fail('Please enter correct pin code.');
                    }
                }
            ],
            'shipping_state' => 'exclude_unless:different_shipping,1|required',
            'shipping_phone_number' => 'exclude_unless:different_shipping,1|required|digits:10',

        ], [

            // Invoice Address Messages
            'first_name.required' => 'Please enter the recipient\'s first name.',
            'email_address.required' => 'Please provide an email address.',
            'email_address.email' => 'Please enter a valid email address.',
            'street.required' => 'Please enter the street address.',
            'city.required' => 'Please enter the city.',
            'postal_code.required' => 'Please enter the postal code.',
            'postal_code.digits' => 'Postal code must be exactly 6 digits.',
            'state.required' => 'Please select a state.',
            'phone_number.required' => 'Please enter the phone number.',
            'phone_number.digits' => 'Phone number must be exactly 10 digits.',

            // Shipping Address Messages
            'shipping_first_name.required' => 'Please enter the shipping recipient\'s first name.',
            'shipping_email.required' => 'Please provide a shipping email address.',
            'shipping_email.email' => 'Please enter a valid shipping email address.',
            'shipping_address.required' => 'Please enter the shipping street address.',
            'shipping_city.required' => 'Please enter the shipping city.',
            'shipping_zip.required' => 'Please enter the shipping postal code.',
            'shipping_zip.digits' => 'Shipping postal code must be exactly 6 digits.',
            'shipping_state.required' => 'Please select the shipping state.',
            'shipping_phone_number.required' => 'Please enter the shipping phone number.',
            'shipping_phone_number.digits' => 'Shipping phone number must be exactly 10 digits.',
        ]);
        $userId = Auth::id();
        UsersAddress::updateOrCreate(
            [
                'user_id' => $userId,
                'address_type' => 'invoice'
            ],
            [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email_address' => $request->email_address,
                'street' => $request->street,
                'city' => $request->city,
                'postal_code' => $request->postal_code,
                'state' => $request->state,
                'phone_number' => $request->phone_number,
            ]
        );
        if ($request->has('different_shipping')) {

            UsersAddress::updateOrCreate(
                [
                    'user_id' => $userId,
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
        }
        return redirect()->route('checkout2');
    }

    public function checkout2()
    {
        $carts = Cart::with('product')
            ->where(function ($q) {
                $q->where('user_id', Auth::id())
                    ->orWhere('session_id', session()->getId());
            })
            ->get();

        return view('checkout2', compact('carts'));
    }
    public function checkout3()
    {
        $carts = Cart::with('product')
            ->where(function ($q) {
                $q->where('user_id', Auth::id())
                    ->orWhere('session_id', session()->getId());
            })
            ->get();

        return view('checkout3', compact('carts'));
    }
    public function checkout4()
    {
        $carts = Cart::with('product')
            ->where(function ($q) {
                $q->where('user_id', Auth::id())
                    ->orWhere('session_id', session()->getId());
            })
            ->get();
        return view('checkout4', compact('carts'));
    }


    public function checkout3Submit(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:card,upi,cod',

            'card_name' => 'exclude_unless:payment_method,card|required|min:3|max:100',
            'card_number' => 'exclude_unless:payment_method,card|required|digits:16',
            'expiry_date' => [
                'exclude_unless:payment_method,card',
                'required',
                'regex:/^(0[1-9]|1[0-2])\/([0-9]{2})$/'
            ],

            'cvv' => 'exclude_unless:payment_method,card|required|digits_between:3,4',
            'zip' => 'exclude_unless:payment_method,card|required|numeric',

            'upi_id' => [
                'exclude_unless:payment_method,upi',
                'required',
                'regex:/^[a-zA-Z0-9.\-_]{2,}@[a-zA-Z]{2,}$/'
            ],

        ], [

            'payment_method.required' => 'Please select a payment method.',

            'card_name.required' => 'Please enter card holder name.',
            'card_name.min' => 'Card holder name must be at least 3 characters.',

            'card_number.required' => 'Please enter card number.',
            'card_number.digits' => 'Card number must be exactly 16 digits.',

            'expiry_date.required' => 'Please enter expiry date.',
            'expiry_date.regex' => 'Expiry date must be in MM/YY format (example: 12/28).',

            'cvv.required' => 'Please enter CVV.',
            'cvv.digits_between' => 'CVV must be 3 or 4 digits.',

            'zip.required' => 'Please enter postal code.',
            'zip.numeric' => 'Postal code must contain only numbers.',

            'upi_id.required' => 'Please enter UPI ID.',
            'upi_id.regex' => 'Please enter a valid UPI ID (example: aditya@upi).',
        ]);

        session([
            'payment_method' => $request->payment_method
        ]);

        return redirect()->route('checkout4');
    }
    public function customerOrderDetails($id)
    {
        $order = Order::with('orderDetails.product')
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        return view('customer-order-details', compact('order'));
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
