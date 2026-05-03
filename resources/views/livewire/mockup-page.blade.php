@php
    use Illuminate\Support\Str;

    $featuredVideo = collect($youtubeVideos)->firstWhere('featured', true);
    $secondaryVideos = collect($youtubeVideos)->reject(fn (array $video): bool => ($video['featured'] ?? false) === true)->values();
@endphp

<div data-mockup-root>
    <script id="mockup-taglines" type="application/json">@json($taglines)</script>

    <nav class="nav">
        <div class="container nav-inner">
            <a href="#top" class="nav-logo">
                <span class="nav-logo-mark">A</span>
                <span>acenaga<span style="color: var(--accent)">.dev</span></span>
            </a>

            <ul class="nav-links">
                <li><a href="#about" data-nav-link="about">{{ $copy['navAbout'] }}</a></li>
                <li><a href="#stack" data-nav-link="stack">{{ $copy['navStack'] }}</a></li>
                <li><a href="#classes" data-nav-link="classes">{{ $copy['navClasses'] }}</a></li>
                <li><a href="#projects" data-nav-link="projects">{{ $copy['navProjects'] }}</a></li>
                <li><a href="#blog" data-nav-link="blog">{{ $copy['navBlog'] }}</a></li>
                <li><a href="#instagram" data-nav-link="instagram">{{ $copy['navInstagram'] }}</a></li>
                <li class="nav-item" style="position: relative;">
                    <button class="nav-dropdown-trigger" data-videos-trigger>
                        {{ $copy['navVideos'] }}
                        <span class="nav-dropdown-caret">▼</span>
                    </button>

                    <ul class="nav-dropdown" data-videos-dropdown>
                        <li><a href="#youtube"><x-mockup-icon name="youtube" :size="14" />{{ $copy['navYoutube'] }}</a></li>
                        <li><a href="#twitch"><x-mockup-icon name="twitch" :size="14" />{{ $copy['navTwitch'] }}</a></li>
                    </ul>
                </li>
                <li><a href="#contact" data-nav-link="contact">{{ $copy['navContact'] }}</a></li>
            </ul>

            <div class="nav-actions">
                <button class="nav-btn" data-theme-toggle aria-label="Cambiar tema">☀</button>
                <button class="nav-mobile-toggle nav-btn" data-mobile-toggle aria-label="Abrir menu">≡</button>
            </div>
        </div>

        <div class="nav-mobile-menu" data-mobile-menu>
            <ul>
                <li><a href="#about" data-nav-link="about">{{ $copy['navAbout'] }}</a></li>
                <li><a href="#stack" data-nav-link="stack">{{ $copy['navStack'] }}</a></li>
                <li><a href="#classes" data-nav-link="classes">{{ $copy['navClasses'] }}</a></li>
                <li><a href="#projects" data-nav-link="projects">{{ $copy['navProjects'] }}</a></li>
                <li><a href="#blog" data-nav-link="blog">{{ $copy['navBlog'] }}</a></li>
                <li><a href="#instagram" data-nav-link="instagram">{{ $copy['navInstagram'] }}</a></li>
                <li><a href="#youtube" data-nav-link="youtube">{{ $copy['navYoutube'] }}</a></li>
                <li><a href="#twitch" data-nav-link="twitch">{{ $copy['navTwitch'] }}</a></li>
                <li><a href="#contact" data-nav-link="contact">{{ $copy['navContact'] }}</a></li>
            </ul>
        </div>
    </nav>

    <section class="hero" id="top">
        <div class="hero-grid-bg"></div>
        <div class="hero-orb hero-orb-1"></div>
        <div class="hero-orb hero-orb-2"></div>

        <div class="container" style="position: relative; z-index: 2;">
            <div class="hero-grid-resp" style="display: grid; grid-template-columns: 1.4fr 1fr; gap: 48px; align-items: center;">
                <div>
                    <div class="eyebrow">{{ $copy['heroEyebrow'] }}</div>

                    <h1 style="font-family: var(--f-display); font-size: clamp(48px, 8vw, 110px); font-weight: 700; line-height: 0.92; letter-spacing: -0.04em; margin-top: 22px;">
                        Hola, soy<br>
                        <span style="color: var(--accent)">Carlos</span><span style="font-family: var(--f-serif); font-style: italic; font-weight: 400;">.</span>
                    </h1>

                    <div style="margin-top: 20px;">
                        <div style="position: relative; min-height: 48px; display: flex; align-items: center; overflow: hidden;">
                            <p class="cursor-blink" data-tagline-text style="font-size: 18px; color: var(--ink-soft); margin: 0;"></p>
                        </div>

                        <div style="display: flex; gap: 8px; margin-top: 14px;">
                            @foreach ($taglines as $index => $tagline)
                                <button
                                    type="button"
                                    wire:key="tagline-dot-{{ $index }}"
                                    data-tagline-dot="{{ $index }}"
                                    aria-label="Tagline {{ $index + 1 }}"
                                    style="width: 8px; height: 8px; border-radius: 4px; background: var(--border-strong); padding: 0; transition: width 0.3s, background 0.3s;"
                                ></button>
                            @endforeach
                        </div>
                    </div>

                    <div style="display: flex; gap: 8px; flex-wrap: wrap; margin-top: 24px;">
                        <span class="sticker" style="transform: rotate(-2deg)">📍 {{ $copy['heroLocation'] }}</span>
                        <span class="sticker" style="transform: rotate(1deg); background: var(--c-yellow-soft)">⏱ <span data-clock></span> · BA</span>
                        <span class="sticker" style="transform: rotate(-1deg); background: #4ade80">● {{ $copy['heroStatusOn'] }}</span>
                    </div>

                    <p style="font-size: 16px; margin-top: 24px; color: var(--ink-soft); max-width: 540px;">
                        {{ $copy['heroAvailability'] }}
                    </p>

                    <div style="display: flex; gap: 14px; margin-top: 36px; flex-wrap: wrap;">
                        <a href="#youtube" class="btn btn-primary glitch">▶ {{ $copy['heroCtaPrimary'] }}</a>
                        <a href="#classes" class="btn">
                            {{ $copy['heroCtaSecondary'] }}
                            <x-mockup-icon name="arrow-right" :size="14" />
                        </a>
                    </div>
                </div>

                <div style="position: relative; max-width: 380px; margin-left: auto;">
                    <div style="position: relative; transform: rotate(2deg);">
                        <div style="position: absolute; inset: 0; background: var(--accent); border-radius: 12px; transform: translate(14px, 14px); z-index: 0;"></div>
                        <div style="position: relative; background: var(--surface-2); border: 3px solid var(--ink); border-radius: 12px; padding: 14px; z-index: 1;">
                            <img src="{{ $carlosImage }}" alt="Carlos Ferrer" style="width: 100%; border-radius: 8px; display: block; filter: contrast(1.05);">
                            <div style="margin-top: 12px; font-family: var(--f-mono); font-size: 11px; display: flex; justify-content: space-between; color: var(--ink-soft);">
                                <span>// IMG_2026.jpg</span>
                                <span>1080×1080</span>
                            </div>
                        </div>
                    </div>

                    <span class="sticker" style="position: absolute; top: -16px; left: -20px; transform: rotate(-12deg); background: #4ade80; z-index: 2;">● ON AIR</span>
                    <span class="sticker" style="position: absolute; bottom: 20px; right: -28px; transform: rotate(8deg); background: var(--c-yellow-soft); z-index: 2;">👨‍💻 dev/teacher</span>
                </div>
            </div>
        </div>
    </section>

    <section id="about" class="reveal">
        <div class="container">
            <div class="about-grid">
                <div>
                    <div class="eyebrow">{{ $copy['aboutEyebrow'] }}</div>
                    <h2 class="section-title">{!! $copy['aboutTitle'] !!}</h2>

                    <div style="margin-top: 32px; display: flex; flex-direction: column; gap: 18px; font-size: 17px; line-height: 1.65; color: var(--ink-soft);">
                        <p>{{ $copy['aboutP1'] }}</p>
                        <p>{{ $copy['aboutP2'] }}</p>
                        <p>{{ $copy['aboutP3'] }}</p>
                    </div>

                    <div class="stat-grid">
                        @foreach ($stats as $index => $stat)
                            <div class="stat" wire:key="stat-{{ $index }}">
                                <div class="stat-num">{{ $stat['num'] }}</div>
                                <div class="stat-label">{{ $stat['label'] }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="about-photo-wrap">
                    <div class="about-photo-frame"></div>
                    <img src="{{ $carlosImage }}" alt="Carlos Ferrer" class="about-photo">
                    <span class="sticker" style="position: absolute; top: -14px; right: -16px; transform: rotate(8deg)">★ Profesor</span>
                    <span class="sticker" style="position: absolute; bottom: 18px; left: -18px; transform: rotate(-6deg); background: var(--c-yellow-soft)">&lt;/&gt; dev</span>
                </div>
            </div>
        </div>
    </section>

    <section id="stack" class="reveal">
        <div class="container">
            <div class="section-head">
                <div class="eyebrow">{{ $copy['stackEyebrow'] }}</div>
                <h2 class="section-title">{!! $copy['stackTitle'] !!}</h2>
                <p style="margin-top: 14px; font-size: 17px; color: var(--ink-soft); max-width: 600px;">{{ $copy['stackSubtitle'] }}</p>
            </div>
        </div>

        <div class="stack-marquee">
            <div class="stack-track">
                @foreach (array_merge($stackMarquee, $stackMarquee) as $index => $item)
                    <span wire:key="stack-marquee-{{ $index }}">{{ $item }}</span>
                @endforeach
            </div>
        </div>

        <div class="container">
            <div class="stack-grid">
                @foreach ($stack as $index => $item)
                    <div class="stack-chip" wire:key="stack-item-{{ $index }}">
                        <span class="stack-chip-icon" style="font-family: var(--f-mono)">{{ $item['icon'] }}</span>
                        <span>{{ $item['name'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section id="classes" class="reveal">
        <div class="container">
            <div class="section-head">
                <div class="eyebrow">{{ $copy['classesEyebrow'] }}</div>
                <h2 class="section-title">{!! $copy['classesTitle'] !!}</h2>
                <p style="margin-top: 14px; font-size: 17px; color: var(--ink-soft); max-width: 600px;">{{ $copy['classesSubtitle'] }}</p>
            </div>

            <div class="classes-grid">
                @foreach ($classes as $index => $class)
                    <article class="class-card" wire:key="class-card-{{ $index }}">
                        <span class="class-num">[{{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}]</span>
                        <div class="class-tag">{{ $class['tag'] }}</div>
                        <h3 class="class-title">{{ $class['title'] }}</h3>
                        <p class="class-desc">{{ $class['desc'] }}</p>
                        <div class="class-meta">
                            <span><x-mockup-icon name="sparkles" :size="12" /> {{ $class['level'] }}</span>
                            <span><x-mockup-icon name="clock" :size="12" /> {{ $class['hours'] }}</span>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section id="projects" class="reveal">
        <div class="container">
            <div class="section-head">
                <div class="eyebrow">{{ $copy['projectsEyebrow'] }}</div>
                <h2 class="section-title">{!! $copy['projectsTitle'] !!}</h2>
                <p style="margin-top: 14px; font-size: 17px; color: var(--ink-soft); max-width: 600px;">{{ $copy['projectsSubtitle'] }}</p>
            </div>

            <div class="projects-grid">
                @foreach ($projects as $index => $project)
                    <a href="{{ $project['url'] }}" class="project-card" wire:key="project-card-{{ $index }}">
                        <div class="project-thumb" style="background: {{ $project['bg'] }};">
                            <div class="project-thumb-inner" style="color: {{ $project['color'] }}; position: relative;">
                                <div style="position: absolute; inset: 0; background-image: radial-gradient(circle, {{ $project['color'] }}33 1px, transparent 1px); background-size: 20px 20px; opacity: 0.6;"></div>
                                <div style="position: relative; text-align: center;">
                                    <div style="font-size: 72px; margin-bottom: 8px;">{{ $project['icon'] }}</div>
                                    <div style="font-family: var(--f-mono); font-size: 11px; letter-spacing: 0.15em; text-transform: uppercase; opacity: 0.8;">
                                        ./{{ Str::slug($project['name']) }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="project-body">
                            <div class="project-tags">
                                @foreach ($project['tags'] as $tagIndex => $tag)
                                    <span class="project-tag" wire:key="project-tag-{{ $index }}-{{ $tagIndex }}">{{ $tag }}</span>
                                @endforeach
                            </div>

                            <h3 class="project-name">
                                {{ $project['name'] }}
                                <span class="project-arrow"><x-mockup-icon name="arrow-up-right" :size="16" /></span>
                            </h3>

                            <p class="project-desc">{{ $project['desc'] }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <section id="blog" class="reveal">
        <div class="container">
            <div class="section-head">
                <div class="eyebrow">{{ $copy['blogEyebrow'] }}</div>
                <h2 class="section-title">{!! $copy['blogTitle'] !!}</h2>
                <p style="margin-top: 14px; font-size: 17px; color: var(--ink-soft); max-width: 600px;">{{ $copy['blogSubtitle'] }}</p>
            </div>

            <div class="posts-grid">
                @foreach ($posts as $index => $post)
                    <article class="post-card" wire:key="post-card-{{ $index }}">
                        <div class="post-meta">
                            <span class="post-cat">{{ $post['cat'] }}</span>
                            <span>{{ $post['date'] }}</span>
                            <span>· {{ $post['readTime'] }}</span>
                        </div>

                        <h3 class="post-title">{{ $post['title'] }}</h3>
                        <p class="post-excerpt">{{ $post['excerpt'] }}</p>

                        <div style="margin-top: 18px; font-family: var(--f-mono); font-size: 12px; color: var(--accent); display: inline-flex; gap: 6px; align-items: center;">
                            {{ $copy['blogReadMore'] }}
                            <x-mockup-icon name="arrow-right" :size="12" />
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section id="instagram" class="reveal">
        <div class="container">
            <div class="section-head" style="display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 24px; max-width: 100%;">
                <div style="max-width: 600px;">
                    <div class="eyebrow">{{ $copy['igEyebrow'] }}</div>
                    <h2 class="section-title">{!! $copy['igTitle'] !!}</h2>
                    <p style="margin-top: 14px; font-size: 17px; color: var(--ink-soft);">{{ $copy['igSubtitle'] }}</p>
                </div>

                <a href="https://instagram.com/acenaga.dev" class="btn btn-primary">
                    <x-mockup-icon name="instagram" :size="16" />
                    {{ $copy['igFollow'] }}
                </a>
            </div>

            <div class="ig-grid">
                @foreach ($instagramPosts as $index => $post)
                    <a href="https://instagram.com/acenaga.dev" class="ig-item" wire:key="ig-item-{{ $index }}" style="background: {{ $post['color'] }};">
                        <div class="ig-item-bg" style="color: {{ $post['accent'] }}; font-size: 40px;">{{ $post['emoji'] }}</div>

                        @if ($post['type'] === 'reel')
                            <div style="position: absolute; top: 8px; right: 8px; width: 22px; height: 22px; display: grid; place-items: center; color: white;">
                                <x-mockup-icon name="play" :size="20" />
                            </div>
                        @elseif ($post['type'] === 'carousel')
                            <div style="position: absolute; top: 8px; right: 8px; color: white; font-size: 16px;">⊞</div>
                        @endif

                        <div class="ig-item-overlay">
                            <div class="ig-item-stats">
                                <span><x-mockup-icon name="heart" :size="11" /> {{ $post['likes'] }}</span>
                                <span><x-mockup-icon name="comment" :size="11" /> {{ $post['cmts'] }}</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <section id="youtube" class="reveal">
        <div class="container">
            <div class="section-head" style="display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 24px; max-width: 100%;">
                <div style="max-width: 600px;">
                    <div class="eyebrow">{{ $copy['ytEyebrow'] }}</div>
                    <h2 class="section-title">{!! $copy['ytTitle'] !!}</h2>
                    <p style="margin-top: 14px; font-size: 17px; color: var(--ink-soft);">{{ $copy['ytSubtitle'] }}</p>
                </div>

                <a href="https://youtube.com/@acenagadev" class="btn btn-primary">
                    <x-mockup-icon name="youtube" :size="16" />
                    {{ $copy['ytSubscribe'] }}
                </a>
            </div>

            <div class="yt-grid">
                @if ($featuredVideo)
                    <a href="https://youtube.com/@acenagadev" class="yt-card featured">
                        <div class="yt-thumb" style="background: {{ $featuredVideo['bg'] }};">
                            <div style="position: absolute; inset: 0; display: grid; place-items: center; color: {{ $featuredVideo['accent'] }}; font-size: 96px;">{{ $featuredVideo['emoji'] }}</div>
                            <div style="position: absolute; bottom: 12px; left: 12px; font-family: var(--f-mono); font-size: 10px; color: {{ $featuredVideo['accent'] }}; letter-spacing: 0.15em; text-transform: uppercase; opacity: 0.85;">./video_001.mp4</div>
                            <div class="yt-play">
                                <div class="yt-play-icon"><x-mockup-icon name="play" :size="26" /></div>
                            </div>
                            <div class="yt-duration">{{ $featuredVideo['duration'] }}</div>
                        </div>

                        <div class="yt-body">
                            <h3 class="yt-title">{{ $featuredVideo['title'] }}</h3>
                            <div class="yt-meta"><x-mockup-icon name="eye" :size="11" /> {{ $featuredVideo['views'] }} views · {{ $featuredVideo['ago'] }}</div>
                        </div>
                    </a>
                @endif

                @foreach ($secondaryVideos as $index => $video)
                    <a href="https://youtube.com/@acenagadev" class="yt-card" wire:key="yt-card-{{ $index }}">
                        <div class="yt-thumb" style="background: {{ $video['bg'] }};">
                            <div style="position: absolute; inset: 0; display: grid; place-items: center; color: {{ $video['accent'] }}; font-size: 64px;">{{ $video['emoji'] }}</div>
                            <div style="position: absolute; bottom: 12px; left: 12px; font-family: var(--f-mono); font-size: 10px; color: {{ $video['accent'] }}; letter-spacing: 0.15em; text-transform: uppercase; opacity: 0.85;">./video_{{ str_pad((string) ($index + 2), 3, '0', STR_PAD_LEFT) }}.mp4</div>
                            <div class="yt-play">
                                <div class="yt-play-icon"><x-mockup-icon name="play" :size="26" /></div>
                            </div>
                            <div class="yt-duration">{{ $video['duration'] }}</div>
                        </div>

                        <div class="yt-body">
                            <h3 class="yt-title">{{ $video['title'] }}</h3>
                            <div class="yt-meta"><x-mockup-icon name="eye" :size="11" /> {{ $video['views'] }} views · {{ $video['ago'] }}</div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <section id="twitch" class="reveal">
        <div class="container">
            <div class="section-head" style="display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 24px; max-width: 100%;">
                <div style="max-width: 600px;">
                    <div class="eyebrow">{{ $copy['twEyebrow'] }}</div>
                    <h2 class="section-title">{!! $copy['twTitle'] !!}</h2>
                    <p style="margin-top: 14px; font-size: 17px; color: var(--ink-soft);">{{ $copy['twSubtitle'] }}</p>
                </div>

                <a href="https://twitch.tv/acenagadev" class="btn btn-primary">
                    <x-mockup-icon name="twitch" :size="16" />
                    {{ $copy['twFollow'] }}
                </a>
            </div>

            <div class="yt-grid">
                @foreach ($twitchStreams as $index => $stream)
                    <a href="https://twitch.tv/acenagadev" class="yt-card{{ ! empty($stream['live']) && $index === 0 ? ' featured' : '' }}" wire:key="tw-card-{{ $index }}">
                        <div class="yt-thumb" style="background: {{ $stream['bg'] }};">
                            <div style="position: absolute; inset: 0; display: grid; place-items: center; color: {{ $stream['accent'] }}; font-size: 72px;">{{ $stream['emoji'] }}</div>
                            <div class="yt-duration">
                                @if (! empty($stream['live']))
                                    {{ $copy['twLive'] }}
                                @else
                                    {{ $stream['duration'] }}
                                @endif
                            </div>
                        </div>

                        <div class="yt-body">
                            <div class="post-meta" style="margin-bottom: 10px;">
                                <span class="post-cat">{{ ! empty($stream['live']) ? $copy['twLive'] : $copy['twVod'] }}</span>
                                <span>{{ $stream['category'] }}</span>
                            </div>
                            <h3 class="yt-title">{{ $stream['title'] }}</h3>
                            <div class="yt-meta">
                                <x-mockup-icon name="eye" :size="11" />
                                @if (! empty($stream['live']))
                                    {{ $stream['viewers'] }} viewers · {{ $stream['ago'] }}
                                @else
                                    {{ $stream['views'] }} views · {{ $stream['ago'] }}
                                @endif
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <section id="contact" class="reveal">
        <div class="container">
            <div class="section-head">
                <div class="eyebrow">{{ $copy['socialEyebrow'] }}</div>
                <h2 class="section-title">{!! $copy['socialTitle'] !!}</h2>
                <p style="margin-top: 14px; font-size: 17px; color: var(--ink-soft); max-width: 600px;">{{ $copy['socialSubtitle'] }}</p>
            </div>

            <div class="social-grid">
                @foreach ($socials as $index => $social)
                    <a href="{{ $social['url'] }}" class="social-card" wire:key="social-card-{{ $index }}" style="transform: rotate({{ $index % 2 === 0 ? '-0.6deg' : '0.6deg' }});">
                        <div class="social-icon"><x-mockup-icon :name="$social['icon']" :size="22" /></div>
                        <div>
                            <div class="social-name">{{ $social['name'] }}</div>
                            <div class="social-handle">{{ $social['handle'] }}</div>
                        </div>
                        <div style="margin-left: auto;"><x-mockup-icon name="arrow-up-right" :size="18" /></div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="container">
            <div class="footer-inner">
                <div>
                    <div>{{ $copy['footerCopy'] }}</div>
                    <div>{{ $copy['footerMade'] }}</div>
                    <div class="footer-clock">
                        <span class="footer-clock-dot"></span>
                        <span>{{ $copy['footerVisitor'] }} #<span class="visitor-counter" data-visitor-counter>00042</span></span>
                    </div>
                </div>
            </div>

            <div style="margin-top: 24px; font-family: var(--f-mono); font-size: 11px; color: var(--ink-dim); text-align: center; opacity: 0.6;">
                ▲ Tip: proba el codigo <span style="color: var(--accent)">↑↑↓↓←→←→BA</span> ▼
            </div>
        </div>
    </footer>

    <div class="easter-toast" data-easter-toast></div>
</div>
