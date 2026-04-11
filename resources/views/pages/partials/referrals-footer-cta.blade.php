@guest
    <div class="mt-8 flex flex-wrap gap-3">
        <a href="{{ route('register') }}" class="inline-flex rounded-full bg-[#869274] px-6 py-2.5 text-sm font-medium text-[#fffffa] hover:brightness-95">Регистрация</a>
        <a href="{{ route('login') }}" class="inline-flex rounded-full border border-[#dcdddb] bg-white px-6 py-2.5 text-sm font-medium text-[#2d312d] hover:bg-[#fafaf8]">Вход</a>
    </div>
@else
    <a href="{{ route('referrals.show') }}" class="mt-6 inline-flex text-sm font-medium text-[#869274] underline underline-offset-2 hover:text-[#2d312d]">Открыть ссылку и код в кабинете →</a>
@endguest
