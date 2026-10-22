<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ config('app.name') }} — Tap. Share. Connect.</title>
  <meta name="description" content="TNS Card: NFC wristbands and digital business cards by Team Network Solutions. One tap opens your page with your name, contact and links.">

  <meta property="og:url" content="{{ url('') }}">
  <meta property="og:type" content="website">
  <meta property="og:title" content="{{ config('app.name') }} — Tap. Share. Connect.">
  <meta property="og:description" content="NFC wristbands and digital business cards. One tap opens your page with your name, contact and links.">
  <meta property="og:image" content="{{ asset('assets/tnscard/images/bands/navy.png') }}">
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="{{ config('app.name') }} — Tap. Share. Connect.">
  <meta name="twitter:description" content="NFC wristbands and digital business cards. One tap opens your page with your name, contact and links.">
  <meta name="twitter:image" content="{{ asset('assets/tnscard/images/bands/navy.png') }}">

  @if(file_exists(base_path("assets/tnscard/images/").findFile('favicon')))
  <link rel="icon" type="image/png" href="{{ asset('assets/tnscard/images/'.findFile('favicon')) }}">
  @else
  <link rel="icon" type="image/svg+xml" href="{{ asset('assets/tnscard/images/logo.svg') }}">
  @endif

  <style>
    @font-face { font-family: 'Inter'; font-style: normal; font-weight: 400; font-display: swap;
      src: url({{ asset('assets/fonts/Inter/inter-latin-400-normal.woff2') }}) format('woff2'), url({{ asset('assets/fonts/Inter/inter-latin-400-normal.woff') }}) format('woff');
      unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD; }
    @font-face { font-family: 'Inter'; font-style: normal; font-weight: 500; font-display: swap;
      src: url({{ asset('assets/fonts/Inter/inter-latin-500-normal.woff2') }}) format('woff2'), url({{ asset('assets/fonts/Inter/inter-latin-500-normal.woff') }}) format('woff');
      unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD; }
    @font-face { font-family: 'Inter'; font-style: normal; font-weight: 600; font-display: swap;
      src: url({{ asset('assets/fonts/Inter/inter-latin-600-normal.woff2') }}) format('woff2'), url({{ asset('assets/fonts/Inter/inter-latin-600-normal.woff') }}) format('woff');
      unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD; }
  </style>
  <link rel="stylesheet" href="{{ asset('assets/tnscard/landing/landing.css') }}?v=5">
</head>
<body>

@php
  $bands = [
    ['key' => 'black', 'img' => asset('assets/tnscard/images/bands/black.webp')],
    ['key' => 'navy',  'img' => asset('assets/tnscard/images/bands/navy.webp')],
    ['key' => 'red',   'img' => asset('assets/tnscard/images/bands/red.webp')],
    ['key' => 'white', 'img' => asset('assets/tnscard/images/bands/white.webp')],
  ];
  $mark = asset('assets/tnscard/images/tns-mark.png');
  $markWhite = asset('assets/tnscard/images/tns-mark-white.png');
  $arrow = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>';
  $xIcon = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" aria-hidden="true"><path d="M6 6l12 12M18 6L6 18"/></svg>';
@endphp

<div class="loader" id="loader" aria-hidden="true">
  <div class="loader__brand" id="loaderBrand">
    <img src="{{ $markWhite }}" alt="">
    <span>TNS Card</span>
  </div>
  <div class="loader__track"><div class="loader__fill"></div></div>
</div>

<main id="top">

  <!-- ========== HERO ========== -->
  <section class="hero" id="hero">
    <div class="hero__bg">
      <div class="hero__bg-inner" data-parallax="0,12">
        <img class="hero__bg-band" src="{{ $bands[3]['img'] }}" alt="" fetchpriority="high">
      </div>
    </div>

    <header class="header">
      <nav class="header__nav" aria-label="Main">
        <a href="#how" data-i18n="nav.how"></a>
        <a href="#products" data-i18n="nav.products"></a>
        <a href="#contact" data-i18n="nav.contact"></a>
      </nav>
      <div class="header__brand">
        <a class="brand" href="{{ url('') }}">
          <img src="{{ $markWhite }}" alt="">
          <span>TNS Card</span>
          <small data-i18n="brand.by"></small>
        </a>
      </div>
      <div class="header__right">
        <div class="lang-switch" role="group" aria-label="Language">
          <button type="button" data-lang="en" aria-pressed="true">EN</button>
          <button type="button" data-lang="es" aria-pressed="false">ES</button>
        </div>
        <a class="header__login" href="{{ url('login') }}" data-i18n="nav.login"></a>
        <button class="burger" type="button" id="menuOpen" aria-label="Menu"><span><i></i><i></i></span></button>
      </div>
    </header>

    <h1 class="hero__title" id="heroTitle" data-i18n="hero.title" data-reveal="words" data-stagger="140" data-duration="1100" data-gated></h1>

    <div class="hero__bottom">
      <div>
        <p class="hero__tagline" data-reveal="lines" data-base="350" data-stagger="110" data-duration="900" data-gated>
          <span data-i18n="hero.tag1"></span>
          <span data-i18n="hero.tag2"></span>
        </p>
        <p class="hero__sub" data-i18n="hero.sub"></p>
        <div class="hero__cta">
          <button type="button" class="pill pill--light" data-open-contact><span data-i18n="cta.get"></span>{!! $arrow !!}</button>
          <a class="pill" style="background:rgba(255,255,255,.12);color:#fff" href="#how"><span data-i18n="cta.how"></span>{!! $arrow !!}</a>
        </div>
      </div>

      <div class="hero__cluster">
        <div class="colors rise" data-delay="650">
          <div class="glass colors__card" id="colorCard">
            <div class="colors__img"><img id="colorImg" src="{{ $bands[0]['img'] }}" alt=""></div>
            <div>
              <div class="colors__brand" data-i18n="colors.brand"></div>
              <div class="colors__title" id="colorTitle"></div>
              <button type="button" class="colors__cta" data-open-contact data-i18n="colors.cta"></button>
            </div>
          </div>
          <div class="dots dots--light" id="colorDots" role="tablist"></div>
        </div>

        <article class="glass phone-card rise" data-delay="780">
          <div class="phone-card__col">
            <div>
              <div class="phone-card__value">1<span style="font-size:1rem;opacity:.7"> tap</span></div>
              <div class="swatches" aria-hidden="true">
                <span style="background:#111"></span><span style="background:#1c2e52"></span><span style="background:#c8283a"></span><span style="background:#fff"></span>
              </div>
            </div>
            <div class="phone-card__caption" data-i18n="hero.cardCaption"></div>
          </div>
          <div class="phone-card__screen" aria-hidden="true">
            <img src="{{ $mark }}" alt=""><b>TNS Card</b><i></i><i></i><i></i>
          </div>
        </article>
      </div>
    </div>
  </section>

  <!-- ========== SHOWCASE ========== -->
  <section class="showcase" id="showcase">
    <div class="showcase__top">
      <div class="badge-circle rise rise--scale">
        <b>NFC</b><small data-i18n="show.badge"></small>
      </div>
      <article class="badge-card rise" data-delay="120">
        <div class="badge-card__chip">TNS<br>One Link</div>
        <div>
          <h3 data-i18n="show.title"></h3>
          <p data-i18n="show.body"></p>
        </div>
      </article>
    </div>

    <div class="showcase__stage">
    <h2 class="ghost" id="ghost" aria-live="polite">
      <div class="ghost__row"><span class="clip" data-ghost="0"><span></span></span><span class="clip" data-ghost="1"><span></span></span></div>
      <div class="ghost__row"><span class="clip is-ink" data-ghost="2"><span></span></span><span class="clip" data-ghost="3"><span></span></span></div>
    </h2>

    <figure class="showcase__figure rise rise--up" id="showFigure">
      <img id="showImg" src="{{ $bands[0]['img'] }}" alt="">
      <figcaption class="showcase__caption"><b id="showName"></b><span id="showRole"></span></figcaption>
    </figure>
    </div>

    <div class="showcase__controls">
      <button type="button" class="arrow-btn arrow-btn--prev" id="showPrev" aria-label="Previous">{!! $arrow !!}</button>
      <div class="dots" id="showDots" role="tablist"></div>
      <button type="button" class="arrow-btn arrow-btn--solid" id="showNext" aria-label="Next">{!! $arrow !!}</button>
    </div>
  </section>

  <!-- ========== PRODUCTS ========== -->
  <section class="products" id="products">
    <span class="eyebrow" data-i18n="products.eyebrow"></span>
    <h2 class="h2" data-reveal="lines"><span data-i18n="products.h1"></span><br><span data-i18n="products.h2"></span></h2>
    <ul class="products__list" id="productsList"></ul>
  </section>

  <!-- ========== HOW IT WORKS ========== -->
  <section class="how" id="how">
    <div class="how__grid">
      <div class="how__intro">
        <div class="how__icon rise rise--scale"><img src="{{ $bands[2]['img'] }}" alt=""></div>
        <h2 class="h2" data-reveal="lines" data-stagger="120"><span data-i18n="how.h1"></span><br><span data-i18n="how.h2"></span><br><span data-i18n="how.h3"></span></h2>
        <p class="how__body" data-reveal="words" data-stagger="28" data-base="250" data-duration="700" data-i18n="how.body"></p>
        <ol class="steps">
          <li class="rise" data-delay="100"><b>1</b><span data-i18n="how.s1"></span></li>
          <li class="rise" data-delay="200"><b>2</b><span data-i18n="how.s2"></span></li>
          <li class="rise" data-delay="300"><b>3</b><span data-i18n="how.s3"></span></li>
        </ol>
      </div>
      <div class="how__cards">
        <figure class="rise hover-scale" data-delay="0">
          <img src="{{ $bands[0]['img'] }}" alt="Black TNS Card NFC wristband">
          <figcaption><b data-i18n="how.c1t"></b><span data-i18n="how.c1d"></span></figcaption>
        </figure>
        <figure class="rise is-navy" data-delay="140">
          <div class="phone-mock" aria-hidden="true">
            <div class="phone-mock__screen">
              <img src="{{ $mark }}" alt=""><b>Maria Lopez</b><small data-i18n="how.exampleRole"></small><i></i><i></i><i></i><i></i>
            </div>
          </div>
          <figcaption><b data-i18n="how.c2t"></b><span data-i18n="how.c2d"></span></figcaption>
        </figure>
      </div>
    </div>
  </section>

  <!-- ========== FACTS ========== -->
  <section class="facts" id="facts">
    <span class="eyebrow eyebrow--light" data-i18n="facts.eyebrow"></span>
    <h2 class="h2" data-reveal="lines"><span data-i18n="facts.h1"></span><br><span data-i18n="facts.h2"></span></h2>
    <dl>
      <dd class="rise" data-delay="0"><b>1</b><span data-i18n="facts.f1"></span></dd>
      <dd class="rise" data-delay="110"><b>0</b><span data-i18n="facts.f2"></span></dd>
      <dd class="rise" data-delay="220"><b>4</b><span data-i18n="facts.f3"></span></dd>
      <dd class="rise" data-delay="330"><b>&infin;</b><span data-i18n="facts.f4"></span></dd>
    </dl>
  </section>

  <!-- ========== FOOTER ========== -->
  <footer class="footer" id="contact">
    <div class="footer__cta">
      <div>
        <span class="eyebrow eyebrow--light" data-i18n="footer.eyebrow"></span>
        <p class="footer__cta-title" data-reveal="lines"><span data-i18n="footer.h1"></span><span data-i18n="footer.h2"></span></p>
      </div>
      <button type="button" class="pill pill--light rise" data-delay="150" data-open-contact><span data-i18n="cta.get"></span>{!! $arrow !!}</button>
    </div>

    <div class="footer__cols">
      <div class="footer__brandcol">
        <a class="brand" href="{{ url('') }}"><img src="{{ $markWhite }}" alt=""><span>TNS Card</span></a>
        <p class="footer__blurb" data-i18n="footer.blurb"></p>
        <address>
          <a href="mailto:info@teamnetworksolutions.com">info@teamnetworksolutions.com</a><br>
          <a href="tel:+19285978266">+1 (928) 597-8266</a><br>
          <span class="muted">281 W 24th St #132, Yuma, AZ 85364</span>
        </address>
      </div>
      <nav class="footer__nav" aria-label="Site">
        <h4 data-i18n="footer.colSite"></h4>
        <ul>
          <li><a href="#how" data-i18n="nav.how"></a></li>
          <li><a href="#products" data-i18n="nav.products"></a></li>
          <li><a href="#showcase" data-i18n="nav.colors"></a></li>
          <li><a href="{{ url('login') }}" data-i18n="nav.login"></a></li>
        </ul>
      </nav>
      <nav class="footer__nav" aria-label="Company">
        <h4 data-i18n="footer.colCompany"></h4>
        <ul>
          <li><a href="https://teamnetworksolutions.com" target="_blank" rel="noopener">Team Network Solutions</a></li>
          <li><a href="https://www.instagram.com/wearetns" target="_blank" rel="noopener">Instagram @wearetns</a></li>
          <li><a href="{{ url('') }}/pages/{{ strtolower(footer('Terms')) }}" data-i18n="footer.terms"></a></li>
          <li><a href="{{ url('') }}/pages/{{ strtolower(footer('Privacy')) }}" data-i18n="footer.privacy"></a></li>
        </ul>
      </nav>
    </div>

    <div class="footer__bottom">
      <a class="footer__logo-link" href="https://teamnetworksolutions.com" target="_blank" rel="noopener" title="Team Network Solutions">
        <img src="{{ $markWhite }}" alt="Team Network Solutions"><span data-i18n="brand.line"></span>
      </a>
      <span>&copy; {{ date('Y') }} Team Network Solutions</span>
      <nav aria-label="Legal">
        <a href="{{ env('SOURCE_CODE_URL', 'https://github.com/TeamNetworkSolutions/tnscard') }}" target="_blank" rel="noopener" data-i18n="footer.source"></a>
      </nav>
    </div>
  </footer>
</main>

<!-- ========== CONTACT MODAL ========== -->
<div class="modal" id="contactModal" aria-hidden="true">
  <div class="modal__backdrop" data-close-contact></div>
  <div class="modal__panel" role="dialog" aria-modal="true" aria-labelledby="contactTitle">
    <div class="modal__head">
      <div>
        <span class="eyebrow" data-i18n="form.eyebrow"></span>
        <h2 class="modal__title" id="contactTitle" data-reveal="lines" data-stagger="90" data-duration="800"><span data-i18n="form.h1"></span><span data-i18n="form.h2"></span></h2>
      </div>
      <button type="button" class="close" data-close-contact aria-label="Close">{!! $xIcon !!}</button>
    </div>

    <form class="form" id="leadForm" action="{{ route('leads.store') }}" method="post" novalidate>
      <input type="hidden" name="form_opened_at" id="formOpenedAt" value="">
      <input type="hidden" name="lang" id="formLang" value="en">
      <div class="hp" aria-hidden="true"><label>Website <input type="text" name="company_website" tabindex="-1" autocomplete="off"></label></div>

      <div class="form__row">
        <div class="field"><label for="f-name" data-i18n="form.name"></label><input id="f-name" name="name" type="text" required autocomplete="name"></div>
        <div class="field"><label for="f-phone" data-i18n="form.phone"></label><input id="f-phone" name="phone" type="tel" required autocomplete="tel"></div>
      </div>
      <div class="form__row">
        <div class="field"><label for="f-email" data-i18n="form.email"></label><input id="f-email" name="email" type="email" required autocomplete="email"></div>
        <div class="field"><label for="f-business" data-i18n="form.business"></label><input id="f-business" name="business" type="text" autocomplete="organization"></div>
      </div>
      <div class="form__row">
        <div class="field"><label for="f-product" data-i18n="form.product"></label>
          <select id="f-product" name="product" required>
            <option value="wristband" data-i18n="form.pWrist"></option>
            <option value="card" data-i18n="form.pCard"></option>
            <option value="sticker" data-i18n="form.pSticker"></option>
            <option value="keychain" data-i18n="form.pKeychain"></option>
            <option value="other" data-i18n="form.pOther"></option>
          </select>
        </div>
        <div class="field"><label for="f-qty" data-i18n="form.qty"></label><input id="f-qty" name="quantity" type="text" inputmode="numeric" placeholder="1"></div>
      </div>
      <div class="field"><label for="f-msg" data-i18n="form.msg"></label><textarea id="f-msg" name="message" rows="3"></textarea></div>
      <p class="form__error" id="formError" data-i18n="form.error"></p>
      <button type="submit" class="pill pill--solid form__submit" id="formSubmit"><span data-i18n="form.send"></span>{!! $arrow !!}</button>
    </form>

    <div class="success" id="formSuccess">
      <div class="success__check"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 13l4 4L19 7"/></svg></div>
      <h3 data-i18n="form.doneTitle"></h3>
      <p id="successText"></p>
      <button type="button" class="pill pill--solid" data-close-contact data-i18n="form.doneBtn"></button>
    </div>
  </div>
</div>

<!-- ========== MENU OVERLAY ========== -->
<div class="menu" id="menu" aria-hidden="true">
  <div class="menu__backdrop" data-close-menu></div>
  <div class="menu__panel">
    <div class="menu__inner">
      <div class="menu__top">
        <a class="brand" href="{{ url('') }}"><img src="{{ $markWhite }}" alt=""><span>TNS Card</span></a>
        <button type="button" class="close close--light" data-close-menu aria-label="Close">{!! $xIcon !!}</button>
      </div>
      <nav class="menu__nav" aria-label="Menu">
        <a href="#how" style="--delay:120ms" data-i18n="nav.how"></a>
        <a href="#products" style="--delay:190ms" data-i18n="nav.products"></a>
        <a href="#showcase" style="--delay:260ms" data-i18n="nav.colors"></a>
        <a href="#contact" style="--delay:330ms" data-i18n="nav.contact"></a>
      </nav>
      <div class="menu__bottom">
        <button type="button" class="pill pill--light" data-open-contact><span data-i18n="cta.get"></span>{!! $arrow !!}</button>
        <nav>
          <a href="{{ url('login') }}" data-i18n="nav.login"></a>
          <a href="https://www.instagram.com/wearetns" target="_blank" rel="noopener">Instagram</a>
          <a href="https://teamnetworksolutions.com" target="_blank" rel="noopener">teamnetworksolutions.com</a>
        </nav>
      </div>
    </div>
  </div>
</div>

<script>
window.TNS = {
  bands: @json($bands),
  i18n: {
    en: {
      'brand.by': 'by Team Network Solutions',
      'brand.line': 'TNS Card by Team Network Solutions',
      'nav.how': 'How it works', 'nav.products': 'Products', 'nav.colors': 'Colors', 'nav.contact': 'Contact', 'nav.login': 'Log in',
      'cta.get': 'Get your TNS Card', 'cta.how': 'See how it works',
      'hero.title': 'Tap. Share. Connect.',
      'hero.tag1': 'One tap. One link.', 'hero.tag2': 'Everything about you.',
      'hero.sub': 'TNS One Link lives inside your NFC wristband. Tap it to any phone and your page opens with your name, contact buttons and links. No app, no paper.',
      'hero.cardCaption': 'opens your page on any phone',
      'colors.brand': 'NFC wristband', 'colors.cta': 'Choose this color',
      'band.black': 'Black', 'band.navy': 'Navy', 'band.red': 'Red', 'band.white': 'White',
      'show.badge': 'built into every wristband',
      'show.title': 'One link that stays current',
      'show.body': 'Your wristband points to your TNS Card page. Change your number, add a new link or update your photo and every band you ever tapped shows the new version.',
      'show.ghost': ['One', 'Tap', 'Every', 'Link'],
      'show.ghost2': ['Your', 'Name', 'Their', 'Phone'],
      'show.ghost3': ['Wear', 'It', 'Share', 'It'],
      'show.ghost4': ['Tap', 'Share', 'Connect', 'Now'],
      'show.role': 'NFC wristband',
      'products.eyebrow': 'Products', 'products.h1': 'Wear it,', 'products.h2': 'or carry it',
      'products.wrist.n': 'NFC wristband', 'products.wrist.d': 'Silicone band with the TNS mark. Tap it to a phone and your page opens.', 'products.wrist.t': 'TNS One Link inside',
      'products.card.n': 'NFC card', 'products.card.d': 'A card-sized version for your wallet. Tap or scan the QR code.', 'products.card.t': 'Also available',
      'products.sticker.n': 'NFC sticker', 'products.sticker.d': 'Stick it on your phone, laptop or counter.', 'products.sticker.t': 'Also available',
      'products.keychain.n': 'NFC keychain', 'products.keychain.d': 'On your keys, always with you.', 'products.keychain.t': 'Also available',
      'how.h1': 'How', 'how.h2': 'TNS One Link', 'how.h3': 'works',
      'how.body': 'We set up your page, program your wristband and hand it to you ready to use. When something changes, we update your page and your band keeps working.',
      'how.s1': 'Tap your wristband to any phone, or let them scan the QR code.',
      'how.s2': 'Your TNS Card page opens: name, title, call, text, email, socials and links.',
      'how.s3': 'They press Save Contact and you are in their phone.',
      'how.c1t': 'The wristband', 'how.c1d': 'NFC chip inside, no battery, no charging.',
      'how.c2t': 'Your page', 'how.c2d': 'Opens in the browser. Nothing to install.',
      'how.exampleRole': 'Example page',
      'facts.eyebrow': 'The basics', 'facts.h1': 'Simple', 'facts.h2': 'on purpose',
      'facts.f1': 'tap to share everything', 'facts.f2': 'apps to install', 'facts.f3': 'wristband colors', 'facts.f4': 'updates, no reprinting',
      'footer.eyebrow': 'Get started', 'footer.h1': 'Ready to', 'footer.h2': 'tap in?',
      'footer.blurb': 'NFC wristbands and digital business cards, set up for you in Yuma, Arizona by Team Network Solutions.',
      'footer.colSite': 'TNS Card', 'footer.colCompany': 'Company',
      'footer.terms': 'Terms', 'footer.privacy': 'Privacy', 'footer.source': 'Source code (AGPL-3.0)',
      'form.eyebrow': 'Get your TNS Card', 'form.h1': 'Tell us', 'form.h2': 'what you need',
      'form.name': 'Full name', 'form.phone': 'Phone', 'form.email': 'Email', 'form.business': 'Business (optional)',
      'form.product': 'I am interested in', 'form.pWrist': 'NFC wristband', 'form.pCard': 'NFC card', 'form.pSticker': 'NFC sticker', 'form.pKeychain': 'NFC keychain', 'form.pOther': 'Not sure yet',
      'form.qty': 'How many', 'form.msg': 'Anything else? (color, team size, questions)',
      'form.send': 'Send request', 'form.sending': 'Sending…',
      'form.error': 'Something went wrong. Check your name, phone and email and try again.',
      'form.doneTitle': 'Request received', 'form.doneText': 'Thanks, {name}. We will call or text you to set up your TNS Card.', 'form.doneBtn': 'Done',
      'menu.close': 'Close'
    },
    es: {
      'brand.by': 'por Team Network Solutions',
      'brand.line': 'TNS Card por Team Network Solutions',
      'nav.how': 'Cómo funciona', 'nav.products': 'Productos', 'nav.colors': 'Colores', 'nav.contact': 'Contacto', 'nav.login': 'Iniciar sesión',
      'cta.get': 'Pide tu TNS Card', 'cta.how': 'Ver cómo funciona',
      'hero.title': 'Toca. Comparte. Conecta.',
      'hero.tag1': 'Un toque. Un enlace.', 'hero.tag2': 'Todo sobre ti.',
      'hero.sub': 'TNS One Link vive dentro de tu pulsera NFC. Tócala con cualquier teléfono y se abre tu página con tu nombre, botones de contacto y enlaces. Sin app, sin papel.',
      'hero.cardCaption': 'abre tu página en cualquier teléfono',
      'colors.brand': 'Pulsera NFC', 'colors.cta': 'Elegir este color',
      'band.black': 'Negro', 'band.navy': 'Azul marino', 'band.red': 'Rojo', 'band.white': 'Blanco',
      'show.badge': 'integrado en cada pulsera',
      'show.title': 'Un enlace que siempre está al día',
      'show.body': 'Tu pulsera apunta a tu página TNS Card. Cambia tu número, agrega un enlace o actualiza tu foto, y cada pulsera que hayas tocado muestra la nueva versión.',
      'show.ghost': ['Un', 'Toque', 'Todos', 'Enlaces'],
      'show.ghost2': ['Tu', 'Nombre', 'En su', 'Teléfono'],
      'show.ghost3': ['Úsala', 'Hoy', 'Comparte', 'Todo'],
      'show.ghost4': ['Toca', 'Comparte', 'Conecta', 'Ya'],
      'show.role': 'Pulsera NFC',
      'products.eyebrow': 'Productos', 'products.h1': 'Llévala puesta', 'products.h2': 'o en el bolsillo',
      'products.wrist.n': 'Pulsera NFC', 'products.wrist.d': 'Pulsera de silicón con el logo TNS. Tócala con un teléfono y se abre tu página.', 'products.wrist.t': 'TNS One Link integrado',
      'products.card.n': 'Tarjeta NFC', 'products.card.d': 'Tamaño tarjeta para tu cartera. Toca o escanea el código QR.', 'products.card.t': 'También disponible',
      'products.sticker.n': 'Sticker NFC', 'products.sticker.d': 'Pégalo en tu teléfono, laptop o mostrador.', 'products.sticker.t': 'También disponible',
      'products.keychain.n': 'Llavero NFC', 'products.keychain.d': 'En tus llaves, siempre contigo.', 'products.keychain.t': 'También disponible',
      'how.h1': 'Cómo', 'how.h2': 'funciona', 'how.h3': 'TNS One Link',
      'how.body': 'Nosotros creamos tu página, programamos tu pulsera y te la entregamos lista para usar. Cuando algo cambie, actualizamos tu página y tu pulsera sigue funcionando.',
      'how.s1': 'Toca tu pulsera con cualquier teléfono, o deja que escaneen el código QR.',
      'how.s2': 'Se abre tu página TNS Card: nombre, puesto, llamar, mensaje, correo, redes y enlaces.',
      'how.s3': 'Presionan Guardar contacto y ya estás en su teléfono.',
      'how.c1t': 'La pulsera', 'how.c1d': 'Chip NFC adentro, sin batería, sin cargar.',
      'how.c2t': 'Tu página', 'how.c2d': 'Se abre en el navegador. Nada que instalar.',
      'how.exampleRole': 'Página de ejemplo',
      'facts.eyebrow': 'Lo básico', 'facts.h1': 'Simple', 'facts.h2': 'a propósito',
      'facts.f1': 'toque para compartir todo', 'facts.f2': 'apps que instalar', 'facts.f3': 'colores de pulsera', 'facts.f4': 'actualizaciones, sin reimprimir',
      'footer.eyebrow': 'Empieza hoy', 'footer.h1': '¿Listo para', 'footer.h2': 'conectar?',
      'footer.blurb': 'Pulseras NFC y tarjetas de presentación digitales, configuradas para ti en Yuma, Arizona por Team Network Solutions.',
      'footer.colSite': 'TNS Card', 'footer.colCompany': 'Empresa',
      'footer.terms': 'Términos', 'footer.privacy': 'Privacidad', 'footer.source': 'Código fuente (AGPL-3.0)',
      'form.eyebrow': 'Pide tu TNS Card', 'form.h1': 'Cuéntanos', 'form.h2': 'qué necesitas',
      'form.name': 'Nombre completo', 'form.phone': 'Teléfono', 'form.email': 'Correo', 'form.business': 'Negocio (opcional)',
      'form.product': 'Me interesa', 'form.pWrist': 'Pulsera NFC', 'form.pCard': 'Tarjeta NFC', 'form.pSticker': 'Sticker NFC', 'form.pKeychain': 'Llavero NFC', 'form.pOther': 'Aún no sé',
      'form.qty': 'Cuántas', 'form.msg': '¿Algo más? (color, tamaño del equipo, preguntas)',
      'form.send': 'Enviar solicitud', 'form.sending': 'Enviando…',
      'form.error': 'Algo salió mal. Revisa tu nombre, teléfono y correo e intenta de nuevo.',
      'form.doneTitle': 'Solicitud recibida', 'form.doneText': 'Gracias, {name}. Te llamaremos o enviaremos un mensaje para configurar tu TNS Card.', 'form.doneBtn': 'Listo',
      'menu.close': 'Cerrar'
    }
  }
};
</script>
<script src="{{ asset('assets/tnscard/js/lenis.min.js') }}"></script>
<script src="{{ asset('assets/tnscard/landing/landing.js') }}?v=3" defer></script>
</body>
</html>
