<div id="cookie-banner" class="hidden px-2 bottom-4 w-full">
    <div
        class="px-3 md:px-8 py-3 bg-white w-fulll md:w-2/3 lg:w-2/5 mx-auto shadow-xl flex flex-col md:flex-row items-center">
        <p class="text-center">We use cookies for critical functionality such as identification and security. By using
            this site you
            agree with our <a href="/privacy" target="_blank" class="text-indigo-700">privacy and cookies policy</a>.
        </p>

        <button class="mt-3 md:mt-0 md:ml-3 border-2 rounder px-2 py-1 border-indigo-700 text-indigo-700 uppercase"
            onclick="dismissBanner()">Dismiss</button>
    </div>
</div>

<script>
    function dismissBanner() {
        Cookies.set('cookie-dismissed', 'true')

        document.getElementById('cookie-banner').classList.replace('fixed', 'hidden')
    }

    if (!Cookies.get('cookie-dismissed')) {
        const cookieBanner = document.getElementById('cookie-banner')
        cookieBanner.classList.replace('hidden', 'fixed')
    }

</script>
