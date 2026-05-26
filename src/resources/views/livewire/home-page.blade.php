<main class="relative min-h-screen overflow-hidden">
    <div class="pointer-events-none absolute inset-0">
        <div class="absolute -top-24 -left-24 h-80 w-80 rounded-full bg-cyan-500/20 blur-3xl"></div>
        <div class="absolute top-24 right-0 h-96 w-96 rounded-full bg-amber-400/10 blur-3xl"></div>
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_30%_10%,rgba(45,212,191,0.18),transparent_35%),radial-gradient(circle_at_80%_40%,rgba(251,191,36,0.12),transparent_30%)]"></div>
        <div class="absolute inset-0 bg-[linear-gradient(to_bottom,rgba(255,255,255,0.03)_1px,transparent_1px),linear-gradient(to_right,rgba(255,255,255,0.03)_1px,transparent_1px)] bg-[size:44px_44px]"></div>
    </div>

    <section class="relative mx-auto flex w-full max-w-6xl flex-col px-6 py-10 md:px-10 md:py-14">
        <header class="mb-12 flex items-center justify-between">
            <div>
                <p class="font-['Space_Grotesk'] text-sm uppercase tracking-[0.24em] text-cyan-300">PortfolioCV</p>
                <h1 class="mt-2 text-2xl font-bold md:text-3xl">Personal Intelligence Card</h1>
            </div>
        </header>

        <div class="grid items-start gap-8 lg:grid-cols-[1.2fr_0.8fr]">
            <article class="rounded-3xl border border-white/10 bg-slate-900/70 p-7 shadow-2xl backdrop-blur">
                <p class="mb-4 inline-flex rounded-full border border-cyan-300/40 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-cyan-200">Laravel + Filament + Livewire</p>
                <h2 class="font-['Space_Grotesk'] text-4xl font-bold leading-tight md:text-5xl">
                    Bangun CV, Portofolio, dan Daftar Publikasi dalam satu panel.
                </h2>
                <p class="mt-5 max-w-2xl text-base leading-7 text-slate-300">
                    Satu kali input dari admin panel, hasilnya langsung sinkron ke halaman publik, kategori publikasi SINTA, dan file PDF siap kirim.
                </p>

                <p class="mt-6 max-w-2xl rounded-xl border border-cyan-400/25 bg-cyan-400/10 px-4 py-3 text-sm text-cyan-100">
                    Platform ini menyatukan identitas profesional, pengalaman kerja, proyek, dan publikasi riset dalam satu profil yang konsisten untuk kebutuhan akademik maupun industri.
                </p>

                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="{{ route('cv.show') }}" class="rounded-xl bg-cyan-300 px-5 py-3 text-sm font-bold text-slate-950 transition hover:bg-cyan-200">Lihat CV Publik</a>
                    <a href="{{ route('cv.download') }}" class="rounded-xl border border-slate-600 px-5 py-3 text-sm font-bold text-slate-200 transition hover:bg-slate-800">Download PDF</a>
                </div>
            </article>

            <aside x-data="{ tab: 'fitur' }" class="rounded-3xl border border-white/10 bg-slate-900/65 p-6 backdrop-blur">
                <h3 class="font-['Space_Grotesk'] text-xl font-semibold">Fitur Unggulan</h3>
                <div class="mt-4 inline-flex rounded-xl border border-slate-700 bg-slate-950/60 p-1 text-xs font-semibold uppercase tracking-wider">
                    <button type="button" @click="tab = 'fitur'" :class="tab === 'fitur' ? 'bg-cyan-300 text-slate-950' : 'text-slate-300'" class="rounded-lg px-3 py-1.5 transition">Fitur</button>
                    <button type="button" @click="tab = 'workflow'" :class="tab === 'workflow' ? 'bg-cyan-300 text-slate-950' : 'text-slate-300'" class="rounded-lg px-3 py-1.5 transition">Workflow</button>
                    <button type="button" @click="tab = 'audit'" :class="tab === 'audit' ? 'bg-cyan-300 text-slate-950' : 'text-slate-300'" class="rounded-lg px-3 py-1.5 transition">Audit</button>
                </div>

                <ul x-show="tab === 'fitur'" x-transition.opacity class="mt-4 space-y-3 text-sm text-slate-300" x-cloak>
                    <li class="rounded-xl border border-slate-800 bg-slate-900 p-3">Sinkronisasi CV web dan PDF secara real-time.</li>
                    <li class="rounded-xl border border-slate-800 bg-slate-900 p-3">Import output SINTA lintas kategori: Scopus, Scholar, Research, IPR, dan Book.</li>
                    <li class="rounded-xl border border-slate-800 bg-slate-900 p-3">Panel admin Filament untuk profile, skill, project, sertifikasi, publikasi, dan lainnya.</li>
                    <li class="rounded-xl border border-slate-800 bg-slate-900 p-3">Kontrol visibilitas per item untuk personalisasi output CV.</li>
                </ul>

                <ol x-show="tab === 'workflow'" x-transition.opacity class="mt-4 space-y-3 text-sm text-slate-300" x-cloak>
                    <li class="rounded-xl border border-slate-800 bg-slate-900 p-3">1. Input data di panel admin Filament.</li>
                    <li class="rounded-xl border border-slate-800 bg-slate-900 p-3">2. Kurasi publikasi hasil import SINTA.</li>
                    <li class="rounded-xl border border-slate-800 bg-slate-900 p-3">3. Publish ke web CV dan export PDF.</li>
                </ol>

                <div x-show="tab === 'audit'" x-transition.opacity class="mt-4 grid gap-3 text-sm text-slate-300" x-cloak>
                    <div class="rounded-xl border border-emerald-400/30 bg-emerald-400/10 p-3 text-emerald-200">Status schema CV: siap produksi.</div>
                    <div class="rounded-xl border border-cyan-400/30 bg-cyan-400/10 p-3 text-cyan-200">Status endpoint publik: aktif.</div>
                    <div class="rounded-xl border border-amber-400/30 bg-amber-400/10 p-3 text-amber-100">Status sinkronisasi: verifikasi berkala disarankan.</div>
                </div>
            </aside>
        </div>

        <section class="mt-10 grid gap-4 md:grid-cols-3">
            <div class="rounded-2xl border border-slate-800 bg-slate-900/70 p-5">
                <p class="text-xs uppercase tracking-widest text-cyan-300">OUTPUT</p>
                <p class="mt-2 text-3xl font-bold">Web CV</p>
                <p class="mt-2 text-sm text-slate-400">Tampilan publik responsif dengan struktur ATS-friendly.</p>
            </div>
            <div class="rounded-2xl border border-slate-800 bg-slate-900/70 p-5">
                <p class="text-xs uppercase tracking-widest text-amber-300">EXPORT</p>
                <p class="mt-2 text-3xl font-bold">PDF</p>
                <p class="mt-2 text-sm text-slate-400">File unduh otomatis dari data profile aktif.</p>
            </div>
            <div class="rounded-2xl border border-slate-800 bg-slate-900/70 p-5">
                <p class="text-xs uppercase tracking-widest text-emerald-300">DATA</p>
                <p class="mt-2 text-3xl font-bold">SINTA</p>
                <p class="mt-2 text-sm text-slate-400">Kategori publikasi terstruktur dan siap kurasi.</p>
            </div>
        </section>

        <section x-data="{ open: 1 }" class="mt-8 rounded-3xl border border-white/10 bg-slate-900/60 p-6 backdrop-blur">
            <h3 class="font-['Space_Grotesk'] text-2xl font-semibold">FAQ Cepat</h3>
            <div class="mt-4 space-y-3">
                <article class="rounded-xl border border-slate-800 bg-slate-900/80">
                    <button type="button" @click="open = open === 1 ? 0 : 1" class="flex w-full items-center justify-between px-4 py-3 text-left font-semibold text-slate-100">
                        <span>Apakah perlu input manual dua kali untuk web dan PDF?</span>
                        <span class="text-cyan-300" x-text="open === 1 ? '-' : '+'"></span>
                    </button>
                    <p x-show="open === 1" x-transition class="px-4 pb-4 text-sm leading-6 text-slate-300" x-cloak>
                        Tidak. Satu sumber data yang sama di admin panel akan dipakai untuk halaman publik dan export PDF.
                    </p>
                </article>

                <article class="rounded-xl border border-slate-800 bg-slate-900/80">
                    <button type="button" @click="open = open === 2 ? 0 : 2" class="flex w-full items-center justify-between px-4 py-3 text-left font-semibold text-slate-100">
                        <span>Apakah publikasi bisa dipilah berdasarkan sumber?</span>
                        <span class="text-cyan-300" x-text="open === 2 ? '-' : '+'"></span>
                    </button>
                    <p x-show="open === 2" x-transition class="px-4 pb-4 text-sm leading-6 text-slate-300" x-cloak>
                        Bisa. Data publikasi disimpan dengan kategori output seperti Scopus, Scholar, Research, IPR, dan Book.
                    </p>
                </article>

                <article class="rounded-xl border border-slate-800 bg-slate-900/80">
                    <button type="button" @click="open = open === 3 ? 0 : 3" class="flex w-full items-center justify-between px-4 py-3 text-left font-semibold text-slate-100">
                        <span>Apakah halaman ini mobile-friendly?</span>
                        <span class="text-cyan-300" x-text="open === 3 ? '-' : '+'"></span>
                    </button>
                    <p x-show="open === 3" x-transition class="px-4 pb-4 text-sm leading-6 text-slate-300" x-cloak>
                        Ya. Layout menggunakan grid responsif Tailwind dengan hierarki konten yang tetap jelas di layar kecil.
                    </p>
                </article>
            </div>
        </section>
    </section>
</main>
