@once
  @push('checkout_scripts')
    @php
      $clientId = core()->getConfigData('sales.paymentmethods.paypal_smart_button.client_id');
      $acceptedCurrency = core()->getConfigData('sales.paymentmethods.paypal_smart_button.accepted_currencies');
    @endphp

    <script src="https://www.paypal.com/sdk/js?client-id={{ $clientId }}&currency={{ $acceptedCurrency }}" data-partner-attribution-id="Bagisto_Cart"></script>
    <script type="text/javascript">
      const messages = {
        universalError: "{{ __('paypal::app.error.universal-error') }}",
        sdkValidationError: "{{ __('paypal::app.error.sdk-validation-error') }}",
        authorizationError: "{{ __('paypal::app.error.authorization-error') }}"
      };

      window.addEventListener('checkout.payment', event => {
        if (event.detail.paymentMethod !== 'paypal_smart_button') {
          return;
        }

        if (!document.querySelector('.paypal-button-container')) {
          return;
        }

        const paypalOptions = {
          style: {
            layout:  'vertical',
            shape:   'rect',
          },

          authorizationFailed: false,

          enableStandardCardFields: false,

          alertBox: function (message) {
            // TODO: Show notification instead of default alert
            alert(message);
          },

          createOrder: function(data, actions) {
            return fetch("{{ route('paypal.smart-button.create-order') }}", { credentials: 'include' })
              .then(function(response) {
                return response.json();
              })
              .then(function(response) {
                return response.result;
              })
              .then(function(orderData) {
                return orderData.id;
              })
              .catch(function (error) {
                if (error.response.data.error === 'invalid_client') {
                  paypalOptions.authorizationFailed = true;
                  paypalOptions.alertBox(messages.authorizationError);
                }

                return error;
              });
          },

          onApprove: function(data, actions) {
            // TODO: show paypal loader
            // app.showLoader();

            fetch("{{ route('paypal.smart-button.capture-order') }}", {
              method: 'POST',
              credentials: 'include',
              headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
              },
              body: JSON.stringify({
                _token: "{{ csrf_token() }}",
                orderData: data
              })
            })
            .then(function(response) {
              return response.json();
            })
            .then(function(response) {
              if (response.success) {
                if (response.redirect_url) {
                  window.location.href = response.data.redirect_url;
                } else {
                  window.location.href = "{{ route('shop.checkout.success') }}";
                }
              }

              // TODO: hide paypayl loader
              // app.hideLoader()
            })
            .catch(function (error) {
              window.location.href = "{{ route('shop.checkout.cart.index') }}";
            })
          },

          onError: function (error) {
            if (!paypalOptions.authorizationFailed) {
              paypalOptions.alertBox(error);
            }
          }
        }

        if (typeof paypal == 'undefined') {
          paypalOptions.alertBox(messages.sdkValidationError);
          return;
        }

        paypal.Buttons(paypalOptions).render('.paypal-button-container');
      })
    </script>
  @endpush
@endonce
