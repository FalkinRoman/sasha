<section id="reviews" class="scroll-mt-24 w-full bg-[#fffffa] py-20 md:py-28">
    <div class="mx-auto w-full max-w-[1440px] px-5 sm:px-8 lg:px-12">
        <div data-pv-reveal class="pv-reveal pv-reveal--fade mx-auto max-w-3xl text-center">
            <h2 class="text-3xl font-semibold tracking-tight text-[#2d312d] md:text-4xl">Они тоже начинали с «я не смогу»</h2>
            <p class="mt-3 text-lg text-[#5c655c]">Теперь пишут «я это сделала».</p>
        </div>

        <div data-pv-reveal class="pv-reveal pv-reveal--up mx-auto mt-12 max-w-3xl" style="--rv-delay: 0.06s">
            <p class="text-center text-sm font-medium text-[#869274]">Видео-отзывы · 15–20 сек</p>
            <div class="pv-video-frame relative mt-4 aspect-video w-full overflow-hidden rounded-2xl">
                <iframe
                    class="absolute inset-0 z-20 hidden h-full w-full"
                    data-youtube-src="https://www.youtube.com/embed/jfKfPfyJRdk"
                    src="about:blank"
                    title="Отзыв"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen
                ></iframe>
                <button
                    type="button"
                    class="absolute inset-0 z-10 flex h-full w-full cursor-pointer items-stretch justify-stretch border-0 bg-transparent p-0"
                    aria-label="Смотреть отзыв"
                    data-youtube-poster-btn
                >
                    <img src="{{ asset('images/figma/promo.png') }}" alt="" class="pointer-events-none absolute inset-0 h-full w-full object-cover">
                    <span class="pv-video-playhint">
                        <span class="pv-video-playhint-icon">
                            <svg class="ml-1 h-7 w-7" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                        </span>
                    </span>
                </button>
            </div>
        </div>

        <div data-pv-reveal class="pv-reveal pv-reveal--fade mt-14" style="--rv-delay: 0.1s">
            <p class="text-center text-sm font-medium text-[#2d312d]">До / после и скрины из переписок</p>
            <div class="mt-6 grid grid-cols-2 gap-4 md:grid-cols-4">
                @foreach (['yoga-first.png', 'yoga-second.png', 'yoga-main2.png', 'yoga-main3.png'] as $img)
                    <div class="overflow-hidden rounded-xl ring-1 ring-[#ecece8]">
                        <img src="{{ asset('images/figma/'.$img) }}" alt="" class="aspect-[3/4] w-full object-cover" loading="lazy">
                    </div>
                @endforeach
            </div>
        </div>

        <p data-pv-reveal class="pv-reveal pv-reveal--fade mx-auto mt-12 max-w-2xl text-center text-lg font-medium text-[#2d312d]" style="--rv-delay: 0.12s">
            Кстати, ко мне ходят даже тренеры по йоге.
        </p>

        <div data-pv-reveal class="pv-reveal pv-reveal--up mx-auto mt-14 max-w-lg" style="--rv-delay: 0.14s">
            <p class="text-center text-sm font-semibold text-[#869274]">Что пишут в нашем чате</p>
            <div class="pv-tg-chat mt-4 space-y-3 rounded-2xl border border-[#dce3db] bg-[#e5ddd5] p-4 md:p-5">
                <div class="flex justify-end">
                    <div class="max-w-[88%] rounded-2xl rounded-br-sm bg-[#dcf8c6] px-3 py-2 text-sm text-[#2d312d] shadow-sm">Саша, после вчерашней практики я проснулась другим человеком 🔥</div>
                </div>
                <div class="flex justify-end">
                    <div class="max-w-[88%] rounded-2xl rounded-br-sm bg-[#dcf8c6] px-3 py-2 text-sm text-[#2d312d] shadow-sm">Впервые за год сделала планку без нытья в голове</div>
                </div>
                <div class="flex justify-start">
                    <div class="max-w-[88%] rounded-2xl rounded-bl-sm bg-white px-3 py-2 text-sm text-[#2d312d] shadow-sm">Вы — молодцы, так держать 💚</div>
                </div>
                <div class="flex justify-end">
                    <div class="max-w-[88%] rounded-2xl rounded-br-sm bg-[#dcf8c6] px-3 py-2 text-sm text-[#2d312d] shadow-sm">Забронила тариф, не думала что так зайдёт</div>
                </div>
            </div>
        </div>
    </div>
</section>
