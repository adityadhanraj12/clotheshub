@extends('layout.app')
@section('section')
  <x-page-header title="Your Profile" />
  <x-customer-sidebar />

  <!-- Content -->
  <div class="col-lg-8 col-xl-9 pl-lg-3">
    <!-- Change Password -->
    <div class="block-header mb-5">
      <h5>Change password</h5>
    </div>
    @if ($errors->any())
      <div class="alert alert-danger">
        {{ $errors->first() }}
      </div>
    @endif
    @if(session('success'))
      <div class="alert alert-success">
        {{ session('success') }}
      </div>
    @endif
    <form class="content-block" method="POST" action="{{ route('changePassword') }}">
      @csrf
      <div class="row">
        <div class="col-sm-6">
          <div class="form-group">
            <label for="password_old" class="form-label">Old password</label>
            <input id="password_old" name="old_password" type="password" class="form-control">
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-sm-6">
          <div class="form-group">
            <label for="password_1" class="form-label">New password</label>
            <input id="password_1" name="new_password" type="password" class="form-control">
          </div>
        </div>

        <div class="col-sm-6">
          <div class="form-group">
            <label for="password_2" class="form-label">Retype new password</label>
            <input id="password_2" name="new_password_confirmation" type="password" class="form-control">
          </div>
        </div>
      </div>

      <div class="text-center">
        <button type="submit" class="btn btn-primary">
          <i class="fa fa-save"></i> Change password
        </button>
      </div>
    </form>

    <!-- Personal Details -->
    <div class="block-header mb-5">
      <h5>Personal details</h5>
    </div>
    <form class="content-block" method="POST" action="{{ route('customerProfile.update') }}">
      @csrf

      <div class="row">
        <div class="col-sm-6">
          <div class="form-group">
            <label for="firstname" class="form-label">Firstname</label>
            <input id="firstname" name="first_name" type="text" class="form-control"
              value="{{ old('first_name', $user->first_name) }}">
          </div>
        </div>

        <div class="col-sm-6">
          <div class="form-group">
            <label for="lastname" class="form-label">Lastname</label>
            <input id="lastname" name="last_name" type="text" class="form-control"
              value="{{ old('last_name', $user->last_name) }}">
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-sm-12">
          <div class="form-group">
            <label for="street" class="form-label">Street</label>
            <input id="street" name="street" type="text" class="form-control" value="{{ old('street', $user->street) }}">
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-sm-6 col-md-4">
          <div class="form-group">
            <label for="city" class="form-label">City</label>
            <input id="city" name="city" type="text" class="form-control" value="{{ old('city', $user->city) }}">
          </div>
        </div>

        <div class="col-sm-6 col-md-4">
          <div class="form-group">
            <label for="zip" class="form-label">Postal Code</label>
            <input id="zip" name="postal_code" type="text" class="form-control"
              value="{{ old('postal_code', $user->postal_code) }}">
          </div>
        </div>

        <div class="col-sm-6 col-md-4">
          <div class="form-group">
            <label for="state" class="form-label">State</label>
            <select id="state" name="state" class="form-control" style="width: 250px; height: 40px; padding: 10px;">
              <option value="">Select State</option>
              @php
                $states = [
                  "Andhra Pradesh",
                  "Arunachal Pradesh",
                  "Assam",
                  "Bihar",
                  "Chhattisgarh",
                  "Goa",
                  "Gujarat",
                  "Haryana",
                  "Himachal Pradesh",
                  "Jharkhand",
                  "Karnataka",
                  "Kerala",
                  "Madhya Pradesh",
                  "Maharashtra",
                  "Manipur",
                  "Meghalaya",
                  "Mizoram",
                  "Nagaland",
                  "Odisha",
                  "Punjab",
                  "Rajasthan",
                  "Sikkim",
                  "Tamil Nadu",
                  "Telangana",
                  "Tripura",
                  "Uttar Pradesh",
                  "Uttarakhand",
                  "West Bengal"
                ];
              @endphp
              @foreach ($states as $state)
                <option value="{{ $state }}" {{ old('state', $user->state ?? '') == $state ? 'selected' : '' }}>
                  {{ $state }}
                </option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="col-sm-6">
          <div class="form-group">
            <label for="phoneNumber" class="form-label">Phone Number</label>
            <input id="phoneNumber" name="phone_number" type="text" class="form-control"
              value="{{ old('phone_number', $user->phone_number) }}">
          </div>
        </div>

        <div class="col-sm-6">
          <div class="form-group">
            <label for="email" class="form-label">Email</label>
            <input id="email" name="email" type="text" class="form-control" value="{{ old('email', $user->email) }}">
          </div>
        </div>

        <div class="col-sm-12 text-center">
          <button type="submit" class="btn btn-primary"> <i class="fa fa-save"></i> Save changes </button>
        </div>
      </div>
    </form>

    <div class="text-center mt-3 mb-4">
      <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteAccountModal">
        <i class="fa fa-trash"></i> Delete Account
      </button>
    </div>

    <!-- Delete Account Confirmation Modal -->
    <div id="deleteAccountModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="background: rgba(0,0,0,0.6); z-index: 9999;">
      <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 550px;">
        <div class="modal-content" style="border-radius: 0; border: none; position: relative;">
          <!-- Close button mimicking the overview close button -->
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="width: 50px; height: 50px; text-align: center; line-height: 50px; background: #9055A2; color: #fff; position: absolute; top: 0; right: 0; opacity: 1; font-size: 1.25rem; border: none; cursor: pointer; outline: none; z-index: 999; display: flex; align-items: center; justify-content: center; padding: 0;">
            <span>&times;</span>
          </button>
          
          <div class="modal-body" style="padding: 50px 30px; text-align: center;">
            <h4 class="text-uppercase mb-4" style="letter-spacing: 0.1em; font-weight: 700; color: #333;">Delete Account</h4>
            <p style="font-weight: 300; line-height: 1.7em; color: #777; font-size: 1.1em; margin-bottom: 30px;">
              Are you sure you want to delete your account?<br><strong>This action cannot be undone.</strong>
            </p>
            <div class="d-flex justify-content-center align-items-center">
              <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal" style="border-radius: 20px; padding: 10px 30px; font-size: 0.9em; text-transform: uppercase; letter-spacing: 0.05em; margin-right: 10px;">Cancel</button>
              <form action="{{ route('customerAccount.delete') }}" method="POST" style="margin: 0;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-template wide" style="border-radius: 20px; padding: 10px 30px; font-size: 0.9em; text-transform: uppercase; letter-spacing: 0.05em; background: #9055A2; border-color: #9055A2; color: #fff;">Delete Account</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
  </div>
  </div>
  </section>

@endsection