@if (\App\Services\Recaptcha::enabled())
    {{-- The badge would sit under the WhatsApp button. Google allows hiding it if this notice is shown. --}}
    <style>.grecaptcha-badge { visibility: hidden; }</style>
    <p class="small text-muted mt-3 mb-0">
        This site is protected by reCAPTCHA and the Google
        <a href="https://policies.google.com/privacy" target="_blank" rel="noopener">Privacy Policy</a> and
        <a href="https://policies.google.com/terms" target="_blank" rel="noopener">Terms of Service</a> apply.
    </p>

    <script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.site_key') }}" async defer></script>
    <script>
        document.querySelectorAll('form[data-recaptcha]').forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (form.dataset.recaptchaDone) {
                    return;
                }

                event.preventDefault();

                if (form.dataset.recaptchaBusy) {
                    return;
                }

                form.dataset.recaptchaBusy = '1';

                // Always send the form: the server decides, and tells the visitor if it can't accept it.
                var send = function (token) {
                    var input = form.querySelector('input[name="g-recaptcha-response"]') || document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'g-recaptcha-response';
                    input.value = token || '';
                    form.appendChild(input);
                    form.dataset.recaptchaDone = '1';
                    // Next tick: browsers ignore requestSubmit() while this submit event is still firing.
                    setTimeout(function () {
                        form.requestSubmit ? form.requestSubmit() : form.submit();
                    });
                };

                // Blocked or slow script (e.g. an ad blocker): don't leave the button doing nothing.
                var fallback = setTimeout(function () { send(''); }, 8000);
                var finish = function (token) {
                    clearTimeout(fallback);
                    if (!form.dataset.recaptchaDone) {
                        send(token);
                    }
                };

                if (!window.grecaptcha) {
                    return;
                }

                grecaptcha.ready(function () {
                    grecaptcha.execute(@js(config('services.recaptcha.site_key')), { action: form.dataset.recaptcha })
                        .then(finish, function () { finish(''); });
                });
            });
        });
    </script>
@endif
