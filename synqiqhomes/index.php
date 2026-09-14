<?php
$project = [
  'name' => 'AI Homes',
  'developer' => 'Highlife',
  'location' => 'Greater Noida West',
  'type' => 'Premium High-Rise',
  'structure' => 'G+18 Floors',
  'road' => '130 m wide road',
  'metro' => 'Near the proposed Metro Station',
  'green' => 'Adjacent to a 100 m fully developed green belt',
  'basicPrice' => '₹11,600/sq.ft.',
  'limitedPrice' => '₹10,600/sq.ft.',
  'price' => '₹10,600/sq.ft.',
  'whatsapp' => '919412234688',
];

$highlights = [
  ['num' => '01', 'title' => 'AI-enabled living', 'text' => 'Lighting, climate, curtains, voice, scenes and control — designed around the way you live.', 'image' => 'assets/project-hero.jpg'],
  ['num' => '02', 'title' => '130 m wide road', 'text' => 'A strong frontage advantage in the heart of Greater Noida West.', 'image' => 'assets/aerial-view.jpg'],
  ['num' => '03', 'title' => '100 m green belt', 'text' => 'An open outlook beside a fully developed green belt.', 'image' => 'assets/highrise.jpg'],
  ['num' => '04', 'title' => 'G+18 premium tower', 'text' => 'A contemporary high-rise format with thoughtfully planned layouts.', 'image' => 'assets/highrise.jpg'],
];

$smartFeatures = [
  ['title' => '17 lighting points', 'text' => 'Move the mood with a lighting setup built around your routine.', 'tag' => 'LIGHT', 'image' => 'assets/project-hero.jpg'],
  ['title' => 'Climate / AC control', 'text' => 'Control room climate from the digital panel or app.', 'tag' => 'CLIMATE', 'image' => 'assets/highrise.jpg'],
  ['title' => 'Motorised curtains', 'text' => 'Curtains can respond to scenes instead of manual effort.', 'tag' => 'CURTAINS', 'image' => 'assets/aerial-view.jpg'],
  ['title' => '8-inch digital panel', 'text' => 'One central screen for light and climate control.', 'tag' => 'PANEL', 'image' => 'assets/project-hero.jpg'],
  ['title' => 'Alexa built in', 'text' => 'Voice control when you want the room to respond.', 'tag' => 'VOICE', 'image' => 'assets/highrise.jpg'],
  ['title' => 'Mobile app', 'text' => 'Your home, from anywhere, through your phone.', 'tag' => 'APP', 'image' => 'assets/aerial-view.jpg'],
  ['title' => 'Sensors + cameras', 'text' => 'Entry, motion and live video features described in the pitch.', 'tag' => 'SENSE', 'image' => 'assets/project-hero.jpg'],
  ['title' => 'Geofencing', 'text' => 'Welcome and away scenes can respond as you leave or arrive.', 'tag' => 'AUTO', 'image' => 'assets/highrise.jpg'],
];

$rooms = [
  ['id' => 'guest', 'name' => 'Guest Room', 'mode' => 'ROUTINE', 'desc' => 'Natural white across every point, flat at its most open.', 'light' => 'Natural white', 'curtain' => 'Open', 'climate' => 'Balanced', 'image' => 'assets/room-guest.jpg'],
  ['id' => 'family', 'name' => 'Family Room', 'mode' => 'RELAX', 'desc' => 'Warm light, curtains drawn halfway, evening settling in.', 'light' => 'Warm glow', 'curtain' => 'Half closed', 'climate' => 'Comfort', 'image' => 'assets/room-family.jpg'],
  ['id' => 'party', 'name' => 'Party Room', 'mode' => 'MASTER', 'desc' => 'Everything up at once, whole floor lit in a single press.', 'light' => 'Full scene', 'curtain' => 'Open', 'climate' => 'Active', 'image' => 'assets/room-party.jpg'],
  ['id' => 'work', 'name' => 'Work Room', 'mode' => 'WORK', 'desc' => 'Cool white over the desk, rest of the room stepping back.', 'light' => 'Cool white', 'curtain' => 'Focused', 'climate' => 'Focused', 'image' => 'assets/room-work.jpg'],
];

$amenities = [
  ['name' => 'Clubhouse', 'image' => 'assets/highrise.jpg', 'meta' => 'SOCIAL'],
  ['name' => 'Gym', 'image' => 'assets/project-hero.jpg', 'meta' => 'FITNESS'],
  ['name' => 'Play area', 'image' => 'assets/aerial-view.jpg', 'meta' => 'FAMILY'],
  ['name' => 'Banquet hall', 'image' => 'assets/highrise.jpg', 'meta' => 'EVENTS'],
  ['name' => 'Yoga', 'image' => 'assets/project-hero.jpg', 'meta' => 'WELLNESS'],
  ['name' => 'International school nearby', 'image' => 'assets/aerial-view.jpg', 'meta' => 'EDUCATION'],
  ['name' => 'Malls in close proximity', 'image' => 'assets/highrise.jpg', 'meta' => 'LIFESTYLE'],
  ['name' => 'Hospitals in close proximity', 'image' => 'assets/aerial-view.jpg', 'meta' => 'ESSENTIALS'],
];

$offers = ['Power backup free', '2-year maintenance free', 'GST free', 'Car parking free* (2BHK only)'];
$nav = [['#home', 'Home'], ['#ai', 'AI Home'], ['#rooms', 'Rooms'], ['#location', 'Location'], ['#plans', 'Plans'], ['#price', 'Price'], ['#lead-form', 'Enquire']];
function e($value)
{
  return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}
function wa($message)
{
  global $project;
  return 'https://wa.me/' . $project['whatsapp'] . '?text=' . rawurlencode($message);
}
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
  <title>SYNQ IQ Homes Greater Noida West | AI Smart Homes</title>
  <meta name="description" content="SYNQ IQ Homes in Greater Noida West with fully furnished 1 & 2 BHK studios, smart automation, premium interiors and modern living.">
  <meta name="robots" content="index, follow, max-image-preview:large">
  <link rel="canonical" href="https://synqiqhomes.com/">
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif']
          }
        }
      }
    }
  </script>
  <style>
    html {
      scroll-behavior: smooth
    }

    body {
      font-family: Inter, ui-sans-serif, system-ui, sans-serif;
      background: #07070a;
      color: #f7f7f7
    }

    * {
      box-sizing: border-box
    }

    body:before {
      content: "";
      position: fixed;
      inset: 0;
      pointer-events: none;
      z-index: 80;
      opacity: .035;
      background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 180 180' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.9' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='.5'/%3E%3C/svg%3E")
    }

    .mesh {
      background: radial-gradient(circle at 15% 10%, rgba(124, 58, 237, .25), transparent 29%), radial-gradient(circle at 88% 17%, rgba(6, 182, 212, .14), transparent 26%), linear-gradient(180deg, #09090c, #07070a)
    }

    .glass {
      background: rgba(255, 255, 255, .055);
      backdrop-filter: blur(20px);
      border: 1px solid rgba(255, 255, 255, .10)
    }

    .reveal {
      opacity: 0;
      transform: translateY(32px);
      transition: opacity .85s cubic-bezier(.2, .7, .2, 1), transform .85s cubic-bezier(.2, .7, .2, 1)
    }

    .reveal.in {
      opacity: 1;
      transform: none
    }

    .card {
      position: relative;
      overflow: hidden;
      transition: transform .5s cubic-bezier(.2, .7, .2, 1), border-color .5s, box-shadow .5s, background .5s
    }

    .card:hover {
      transform: translateY(-9px);
      border-color: rgba(167, 139, 250, .42);
      box-shadow: 0 30px 90px rgba(0, 0, 0, .38)
    }

    .card:after {
      content: "";
      position: absolute;
      inset: -1px;
      background: linear-gradient(120deg, transparent 20%, rgba(255, 255, 255, .11), transparent 65%);
      transform: translateX(-120%);
      transition: transform .8s;
      pointer-events: none
    }

    .card:hover:after {
      transform: translateX(120%)
    }

    .media img {
      transition: transform .9s cubic-bezier(.2, .7, .2, 1), filter .6s
    }

    .media:hover img {
      transform: scale(1.08);
      filter: saturate(1.1) contrast(1.05)
    }

    .heroImage {
      transform: scale(1.03);
      transition: transform 1.4s cubic-bezier(.2, .7, .2, 1)
    }

    .hero:hover .heroImage {
      transform: scale(1.085)
    }

    .float {
      animation: float 5s ease-in-out infinite
    }

    @keyframes float {

      0%,
      100% {
        transform: translateY(0)
      }

      50% {
        transform: translateY(-9px)
      }
    }

    .pulseDot {
      animation: pulse 2.2s infinite
    }

    @keyframes pulse {

      0%,
      100% {
        box-shadow: 0 0 0 0 rgba(34, 211, 238, .35)
      }

      50% {
        box-shadow: 0 0 0 10px rgba(34, 211, 238, 0)
      }
    }

    .marquee {
      animation: marquee 24s linear infinite
    }

    @keyframes marquee {
      to {
        transform: translateX(-50%)
      }
    }

    .scan {
      position: relative;
      overflow: hidden
    }

    .scan:before {
      content: "";
      position: absolute;
      left: 0;
      right: 0;
      height: 2px;
      top: -10%;
      background: linear-gradient(90deg, transparent, rgba(103, 232, 249, .8), transparent);
      box-shadow: 0 0 28px rgba(103, 232, 249, .55);
      animation: scan 4.5s linear infinite;
      z-index: 3
    }

    @keyframes scan {
      to {
        top: 110%
      }
    }

    .btn {
      transition: transform .28s, box-shadow .28s
    }

    .btn:hover {
      transform: translateY(-3px);
      box-shadow: 0 18px 45px rgba(0, 0, 0, .32)
    }

    .roomTab {
      transition: all .35s
    }

    .roomTab:hover {
      transform: translateX(5px);
      background: rgba(255, 255, 255, .07)
    }

    .roomImage {
      transition: transform .7s cubic-bezier(.2, .7, .2, 1), filter .7s
    }

    .roomCard:hover .roomImage {
      transform: scale(1.07);
      filter: brightness(1.12) saturate(1.08)
    }

    .glowText {
      text-shadow: 0 0 35px rgba(167, 139, 250, .22)
    }

    @media(max-width:640px) {
      .glass {
        backdrop-filter: blur(13px)
      }

      .heroTitle {
        letter-spacing: -.065em
      }

      .hideMobile {
        display: none
      }
    }
  </style>
</head>

<body class="selection:bg-violet-300/30">
  <header class="fixed top-0 inset-x-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 pt-4">
      <nav class="glass rounded-2xl px-4 py-3 flex items-center justify-between"><a href="#home" class="font-black tracking-tight text-lg">SYNQ<span class="text-violet-300"></span></a>
        <div class="hidden lg:flex items-center gap-7 text-sm text-white/60"><?php foreach ($nav as $item): ?><a class="hover:text-white transition" href="<?= e($item[0]) ?>"><?= e($item[1]) ?></a><?php endforeach; ?></div><button id="menuBtn" class="lg:hidden ml-2 w-10 h-10 rounded-full border border-white/10 text-xl" aria-label="Open menu">☰</button>
      </nav>
      <div id="mobileMenu" class="hidden glass mt-2 rounded-2xl p-3 lg:hidden"><?php foreach ($nav as $item): ?><a class="block px-3 py-3 rounded-xl hover:bg-white/10" href="<?= e($item[0]) ?>"><?= e($item[1]) ?></a><?php endforeach; ?></div>
    </div>
  </header>

  <main>
    <section id="home" class="hero min-h-screen pt-28 pb-12 mesh overflow-hidden">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 grid lg:grid-cols-[1.03fr_.97fr] gap-10 items-center">
        <div class="reveal">
          <div class="inline-flex items-center gap-2 glass rounded-full px-3 py-2 text-xs text-white/65 mb-6"><span class="pulseDot w-2 h-2 rounded-full bg-cyan-300"></span> AI-enabled living • Greater Noida West</div>
          <h1 class="heroTitle glowText text-2xl sm:text-6xl lg:text-7xl font-black leading-[.9] tracking-[-.07em] text-transparent bg-clip-text bg-gradient-to-r from-violet-200 via-white to-cyan-200">Synq IQ Home – Beautiful Living.</h1>
          <p class="mt-7 max-w-xl text-base sm:text-lg leading-8 text-white/58">AI Homes by Highlife combines a premium G+18 high-rise with an AI-led home experience — lighting, climate, curtains, voice, scenes and control from anywhere.</p>
          <div class="mt-8 flex flex-wrap gap-3"><a class="btn rounded-full bg-white text-black px-6 py-3.5 font-bold" href="#lead-form">Book a conversation <span>↗</span></a><a id="brochureBtn" class="btn rounded-full glass px-6 py-3.5 font-bold" href="#lead-form">Request brochure <span class="text-violet-200">↘</span></a></div>
          <div class="mt-10 grid grid-cols-2 sm:grid-cols-4 gap-3 max-w-2xl"><?php foreach ([['G+18', 'Tower'], ['1 & 2', 'BHK'], ['130 m', 'Road'], ['100 m', 'Green belt']] as $x): ?><div class="card glass rounded-2xl p-4 reveal">
                <div class="text-xl font-black"><?= e($x[0]) ?></div>
                <div class="text-xs text-white/40 mt-1 uppercase tracking-widest"><?= e($x[1]) ?></div>
              </div><?php endforeach; ?></div>
        </div>
        <div class="reveal relative">
          <div class="absolute -inset-8 bg-violet-500/10 blur-3xl rounded-full pointer-events-none"></div>
          <div class="relative rounded-[2rem] overflow-hidden border border-white/10 shadow-2xl shadow-black/50 scan media"><img class="heroImage w-full aspect-[4/5] object-cover" src="assets/project-hero.jpg" alt="AI Homes high-rise view">
            <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-transparent to-black/10"></div>
            <div class="absolute left-5 right-5 bottom-5 glass rounded-2xl p-5 flex items-end justify-between gap-4">
              <div>
                <div class="text-[10px] uppercase tracking-[.25em] text-cyan-200/60">Designed around life</div>
                <div class="text-xl sm:text-2xl font-black mt-1">One home. Many states.</div>
              </div>
              <div class="text-right">
                <div class="text-xs text-white/40">Starting at</div>
                <div class="font-black text-lg"><?= e($project['price']) ?></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="py-5 border-y border-white/5 overflow-hidden bg-[#09090c]">
      <div class="flex whitespace-nowrap marquee w-max text-[10px] sm:text-xs uppercase tracking-[.32em] text-white/30"><span class="mx-8">SMART LIGHTING</span><span class="mx-8">CLIMATE CONTROL</span><span class="mx-8">MOTORISED CURTAINS</span><span class="mx-8">VOICE CONTROL</span><span class="mx-8">GEOFENCING</span><span class="mx-8">G+18 HIGH-RISE</span><span class="mx-8">GREATER NOIDA WEST</span><span class="mx-8">SMART LIGHTING</span><span class="mx-8">CLIMATE CONTROL</span><span class="mx-8">MOTORISED CURTAINS</span><span class="mx-8">VOICE CONTROL</span><span class="mx-8">GEOFENCING</span><span class="mx-8">G+18 HIGH-RISE</span></div>
    </section>

    <section id="ai" class="py-24 sm:py-32">
      <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="grid lg:grid-cols-[.7fr_1.3fr] gap-12 items-end">
          <div class="reveal">
            <p class="text-cyan-300 text-xs font-bold uppercase tracking-[.25em]">01 / The AI layer</p>
            <h2 class="mt-4 text-4xl sm:text-6xl font-black tracking-[-.055em]">Not gadgets.<br><span class="text-white/30">A living system.</span></h2>
            <p class="mt-6 text-white/45 leading-7 max-w-md">The pitch frames the home around one screen, one voice and control from anywhere. This section turns those ideas into a visual system.</p>
          </div>
          <div class="grid sm:grid-cols-2 gap-4"><?php foreach ($smartFeatures as $i => $f): ?><article class="reveal card glass rounded-[1.6rem] overflow-hidden min-h-[285px] group">
                <div class="media absolute inset-0"><img src="<?= e($f['image']) ?>" class="w-full h-full object-cover opacity-30 group-hover:opacity-55" alt="<?= e($f['title']) ?> visual">
                  <div class="absolute inset-0 bg-gradient-to-t from-[#08080b] via-[#08080b]/65 to-transparent"></div>
                </div>
                <div class="relative z-10 p-6 h-full flex flex-col justify-end">
                  <div class="flex items-center justify-between"><span class="text-[10px] tracking-[.25em] text-cyan-200/60"><?= e($f['tag']) ?></span><span class="text-xs text-white/20">0<?= e($i + 1) ?></span></div>
                  <h3 class="mt-3 text-xl font-black"><?= e($f['title']) ?></h3>
                  <p class="mt-2 text-sm leading-6 text-white/45 max-w-sm"><?= e($f['text']) ?></p>
                  <div class="mt-5 h-px bg-white/10">
                    <div class="h-px w-1/3 bg-gradient-to-r from-violet-300 to-cyan-300 group-hover:w-full transition-all duration-700"></div>
                  </div>
                </div>
              </article><?php endforeach; ?></div>
        </div>
      </div>
    </section>

    <section id="rooms" class="py-24 sm:py-32 bg-[#0b0b0f] border-y border-white/5">
      <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="reveal max-w-3xl">
          <p class="text-violet-300 text-xs font-bold uppercase tracking-[.25em]">02 / One room, four identities</p>
          <h2 class="mt-4 text-4xl sm:text-6xl font-black tracking-[-.055em]">The same square feet.<br><span class="text-white/30">A different feeling.</span></h2>
        </div>
        <div class="mt-12 grid lg:grid-cols-[.42fr_1fr] gap-5">
          <div class="space-y-2"><?php foreach ($rooms as $i => $r): ?><button class="roomTab w-full text-left glass rounded-2xl p-5 flex items-center justify-between gap-4 <?= $i === 0 ? 'bg-white text-black' : 'text-white/60' ?>" data-room="<?= e($r['id']) ?>">
                <div>
                  <div class="text-xs uppercase tracking-[.2em] opacity-50">0<?= e($i + 1) ?> / <?= e($r['mode']) ?></div>
                  <div class="font-black text-lg mt-1"><?= e($r['name']) ?></div>
                </div><span>↗</span>
              </button><?php endforeach; ?></div>
          <div id="roomVisual" class="roomCard reveal relative min-h-[520px] rounded-[2rem] overflow-hidden border border-white/10">
            <div id="roomImageWrap" class="absolute inset-0"><img id="roomImage" src="assets/room-guest.jpg" class="roomImage w-full h-full object-cover" alt="Guest Room scene"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-black via-black/25 to-transparent"></div>
            <div class="absolute top-5 left-5 glass rounded-full px-4 py-2 text-[10px] uppercase tracking-[.24em]">Scene system / <span id="roomMode">ROUTINE</span></div>
            <div class="absolute inset-x-6 bottom-6">
              <div class="text-sm text-cyan-200/65 uppercase tracking-[.22em]">Four identities</div>
              <h3 id="roomName" class="text-4xl sm:text-6xl font-black tracking-[-.055em] mt-2">Guest Room</h3>
              <p id="roomDesc" class="mt-4 max-w-xl text-white/55 leading-7">Natural white across every point, flat at its most open.</p>
              <div class="mt-7 grid grid-cols-3 gap-2 max-w-xl">
                <div class="glass rounded-2xl p-4">
                  <div class="text-[9px] text-white/35 uppercase tracking-widest">Light</div>
                  <div id="roomLight" class="mt-2 text-sm font-bold">Natural white</div>
                </div>
                <div class="glass rounded-2xl p-4">
                  <div class="text-[9px] text-white/35 uppercase tracking-widest">Curtain</div>
                  <div id="roomCurtain" class="mt-2 text-sm font-bold">Open</div>
                </div>
                <div class="glass rounded-2xl p-4">
                  <div class="text-[9px] text-white/35 uppercase tracking-widest">Climate</div>
                  <div id="roomClimate" class="mt-2 text-sm font-bold">Balanced</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="py-24 sm:py-32">
      <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="grid lg:grid-cols-2 gap-6">
          <div class="reveal card rounded-[2rem] overflow-hidden relative min-h-[600px] media"><img src="assets/aerial-view.jpg" class="absolute inset-0 w-full h-full object-cover" alt="AI Homes aerial view">
            <div class="absolute inset-0 bg-gradient-to-t from-black via-black/35 to-transparent"></div>
            <div class="absolute left-7 right-7 bottom-7">
              <div class="text-xs uppercase tracking-[.25em] text-cyan-200/60">03 / What changes every day</div>
              <h2 class="mt-3 text-4xl sm:text-5xl font-black tracking-[-.055em]">Things you feel<br>from day one.</h2>
              <p class="mt-5 max-w-lg text-white/50 leading-7">Glass touch switches. Motorised curtains. AC control via app. Geofencing. Welcome and away scenes.</p>
            </div>
          </div>
          <div class="grid sm:grid-cols-2 gap-4"><?php foreach ($highlights as $i => $h): ?><article class="reveal card glass rounded-[1.7rem] p-6 min-h-[285px] flex flex-col justify-between">
                <div class="flex justify-between"><span class="text-4xl font-black text-white/10"><?= e($h['num']) ?></span><span class="w-9 h-9 rounded-full border border-white/10 flex items-center justify-center text-xs text-violet-200">↗</span></div>
                <div>
                  <h3 class="text-xl font-black"><?= e($h['title']) ?></h3>
                  <p class="mt-3 text-sm text-white/43 leading-6"><?= e($h['text']) ?></p>
                  <div class="mt-5 h-28 rounded-2xl overflow-hidden media"><img src="<?= e($h['image']) ?>" class="w-full h-full object-cover opacity-55" alt="<?= e($h['title']) ?>"></div>
                </div>
              </article><?php endforeach; ?></div>
        </div>
      </div>
    </section>

    <section id="location" class="py-24 sm:py-32 bg-[#0b0b0f] border-y border-white/5">
      <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="grid lg:grid-cols-[.8fr_1.2fr] gap-12">
          <div class="reveal">
            <p class="text-cyan-300 text-xs font-bold uppercase tracking-[.25em]">04 / Location intelligence</p>
            <h2 class="mt-4 text-4xl sm:text-6xl font-black tracking-[-.055em]">Connected to<br><span class="text-white/30">what matters.</span></h2>
            <p class="mt-6 text-white/45 leading-7 max-w-md">Prime location in Greater Noida West with access through NH 24, Noida–Greater Noida Link Road and F&G, as presented in the deck.</p>
          </div>
          <div class="grid sm:grid-cols-2 gap-4">
            <div class="reveal card glass rounded-3xl p-7 min-h-[220px]">
              <div class="text-cyan-200 text-4xl font-black">130<span class="text-xl">m</span></div>
              <h3 class="mt-8 font-black text-xl">Wide road</h3>
              <p class="mt-2 text-sm text-white/40">Located on a 130 m wide road.</p>
            </div>
            <div class="reveal card glass rounded-3xl p-7 min-h-[220px]">
              <div class="text-violet-200 text-4xl font-black">100<span class="text-xl">m</span></div>
              <h3 class="mt-8 font-black text-xl">Green belt</h3>
              <p class="mt-2 text-sm text-white/40">Adjacent to a fully developed green belt.</p>
            </div>
            <div class="reveal card glass rounded-3xl p-7 min-h-[220px]">
              <div class="text-4xl">⌁</div>
              <h3 class="mt-8 font-black text-xl">Proposed Metro</h3>
              <p class="mt-2 text-sm text-white/40">Near the proposed Metro Station.</p>
            </div>
            <div class="reveal card glass rounded-3xl p-7 min-h-[220px]">
              <div class="text-4xl">⌂</div>
              <h3 class="mt-8 font-black text-xl">Everyday access</h3>
              <p class="mt-2 text-sm text-white/40">International school, malls and hospitals in proximity.</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="plans" class="py-24 sm:py-32">
      <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="reveal max-w-3xl">
          <p class="text-violet-300 text-xs font-bold uppercase tracking-[.25em]">05 / Architecture & plans</p>
          <h2 class="mt-4 text-4xl sm:text-6xl font-black tracking-[-.055em]">More usable area.<br><span class="text-white/30">Smarter planning.</span></h2>
          <p class="mt-5 text-white/45 leading-7">The presentation highlights more usable area, a lower saleable ratio and smart planning, with 1 BHK and 2 BHK unit plans.</p>
        </div>
        <div class="mt-12 grid lg:grid-cols-2 gap-5"><?php foreach ([['type' => '1 BHK', 'saleable' => '89.60 sq.m / 964 sq.ft.', 'built' => '55.10 sq.m / 593 sq.ft.', 'carpet' => '42.32 sq.m / 456 sq.ft.', 'image' => 'assets/1bhk-plan.png', 'stats' => 'assets/1bhk-stats.png'], ['type' => '2 BHK', 'saleable' => '135.12 sq.m / 1454 sq.ft.', 'built' => '84.23 sq.m / 906 sq.ft.', 'carpet' => '63.92 sq.m / 688 sq.ft.', 'image' => 'assets/2bhk-plan.png', 'stats' => 'assets/2bhk-stats.png']] as $p): ?><article class="reveal card glass rounded-[2rem] overflow-hidden">
              <div class="p-6 sm:p-7 flex items-center justify-between">
                <div>
                  <div class="text-xs uppercase tracking-[.22em] text-white/35">Unit plan</div>
                  <h3 class="text-3xl font-black mt-2"><?= e($p['type']) ?></h3>
                </div><span class="rounded-full border border-white/10 px-4 py-2 text-xs text-white/40">Explore ↗</span>
              </div>
              <div class="grid grid-cols-2 gap-2 p-3">
                <div class="rounded-2xl overflow-hidden bg-white media"><img src="<?= e($p['image']) ?>" class="w-full aspect-square object-contain" alt="<?= e($p['type']) ?> unit plan"></div>
                <div class="rounded-2xl overflow-hidden bg-white media"><img src="<?= e($p['stats']) ?>" class="w-full aspect-square object-contain" alt="<?= e($p['type']) ?> area details"></div>
              </div>
              <div class="grid grid-cols-3 gap-2 p-6">
                <div>
                  <div class="text-[9px] uppercase tracking-widest text-white/30">Saleable</div>
                  <div class="text-sm font-bold mt-1"><?= e($p['saleable']) ?></div>
                </div>
                <div>
                  <div class="text-[9px] uppercase tracking-widest text-white/30">Built-up</div>
                  <div class="text-sm font-bold mt-1"><?= e($p['built']) ?></div>
                </div>
                <div>
                  <div class="text-[9px] uppercase tracking-widest text-white/30">Carpet</div>
                  <div class="text-sm font-bold mt-1"><?= e($p['carpet']) ?></div>
                </div>
              </div>
            </article><?php endforeach; ?></div>
        <div class="mt-5 reveal card glass rounded-[2rem] p-6 sm:p-8 flex flex-col lg:flex-row lg:items-center justify-between gap-5">
          <div>
            <div class="text-xs uppercase tracking-[.25em] text-white/30">Premium high-rise</div>
            <div class="text-2xl font-black mt-2">G+18 floors • Fully furnished positioning</div>
          </div>
          <div class="text-sm text-white/40 max-w-md">The pitch also presents a typical floor plan and fully furnished positioning.</div>
        </div>
      </div>
    </section>

    <section id="amenities" class="py-24 sm:py-32 bg-[#0b0b0f] border-y border-white/5">
      <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="reveal text-center max-w-3xl mx-auto">
          <p class="text-cyan-300 text-xs font-bold uppercase tracking-[.25em]">06 / Everyday ecosystem</p>
          <h2 class="mt-4 text-4xl sm:text-6xl font-black tracking-[-.055em]">Amenities that<br><span class="text-white/30">complete the address.</span></h2>
        </div>
        <div class="mt-12 grid sm:grid-cols-2 lg:grid-cols-4 gap-4"><?php foreach ($amenities as $i => $a): ?><article class="reveal card glass rounded-[1.7rem] overflow-hidden group">
              <div class="h-48 media relative"><img src="<?= e($a['image']) ?>" class="w-full h-full object-cover opacity-45 group-hover:opacity-70" alt="<?= e($a['name']) ?>">
                <div class="absolute inset-0 bg-gradient-to-t from-[#0b0b0f] to-transparent"></div><span class="absolute top-4 left-4 glass rounded-full px-3 py-1 text-[9px] tracking-[.2em]"><?= e($a['meta']) ?></span>
              </div>
              <div class="p-5">
                <div class="text-xs text-white/25">0<?= e(($i % 8) + 1) ?></div>
                <h3 class="mt-3 font-black text-lg"><?= e($a['name']) ?></h3>
                <div class="mt-4 text-violet-200 text-xs opacity-0 group-hover:opacity-100 transition">Explore detail ↗</div>
              </div>
            </article><?php endforeach; ?></div>
      </div>
    </section>

    <section id="price" class="py-24 sm:py-32">
      <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="reveal max-w-3xl">
          <p class="text-violet-300 text-xs font-bold uppercase tracking-[.25em]">07 / Price architecture</p>
          <h2 class="mt-4 text-4xl sm:text-6xl font-black tracking-[-.055em]">Numbers with<br><span class="text-white/30">room to move.</span></h2>
          <p class="mt-5 text-white/45 leading-7">Prices shown are based on the basic information and are subject to change. Please confirm the latest pricing, availability, and payment terms with our expert.</p>
        </div>
        <div class="mt-12  grid lg:grid-cols-3 gap-4"><?php foreach ([['label' => 'Basic price', 'value' => $project['basicPrice'], 'note' => 'As presented'], ['label' => 'Limited-time offer', 'value' => $project['limitedPrice'], 'note' => '₹1,000/sq.ft. NPV discount mentioned'], ['label' => 'Post NPV figure', 'value' => $project['price'], 'note' => 'As shown in the presentation']] as $i => $p): ?><div class="reveal card <?= $i === 1 ? 'bg-gradient-to-br from-violet-500/20 to-cyan-500/10 border-violet-300/20' : 'glass' ?> rounded-[2rem] p-7 min-h-[180px] flex flex-col justify-between">
              <div>
                <div class="text-xs uppercase tracking-[.2em] text-white/35"><?= e($p['label']) ?></div>
                <div class="text-4xl sm:text-5xl font-black mt-5 tracking-[-.04em]"><?= e($p['value']) ?></div>
              </div>
            </div><?php endforeach; ?></div>
        <div class="mt-5 grid lg:grid-cols-2 gap-4">
          <div class="reveal card glass rounded-[2rem] p-7 min-h-[180px]">
            <div class="text-xs uppercase tracking-[.2em] text-white/35">Payment plan</div>
            <div class="text-5xl font-black mt-5 tracking-[-.05em]">40 : 40 : 20</div>
          </div>
          <div class="reveal card glass rounded-[2rem] p-7 min-h-[180px]">
            <div class="text-xs uppercase tracking-[.2em] text-white/35">Construction-linked</div>
            <div class="text-3xl font-black mt-5">Construction Link Plan</div>
          </div>
        </div>
      </div>
    </section>

    <section class="py-24 sm:py-32 bg-[#0b0b0f] border-y border-white/5">
      <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="reveal text-center max-w-3xl mx-auto">
          <p class="text-cyan-300 text-xs font-bold uppercase tracking-[.25em]">08 / Included advantages</p>
          <h2 class="mt-4 text-4xl sm:text-6xl font-black tracking-[-.055em]">More value,<br><span class="text-white/30">built into the story.</span></h2>
        </div>
        <div class="mt-12 grid sm:grid-cols-2 lg:grid-cols-4 gap-4"><?php foreach ($offers as $i => $o): ?><div class="reveal card glass rounded-[1.8rem] p-7 min-h-[200px] group">
              <div class="text-5xl font-black text-white/10 group-hover:text-violet-200/20 transition">0<?= e($i + 1) ?></div>
              <h3 class="mt-12 font-black text-lg"><?= e($o) ?></h3>
            </div><?php endforeach; ?></div>
      </div>
    </section>

    <section id="contact" class="py-24 sm:py-32">
      <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="grid lg:grid-cols-[.9fr_1.1fr] gap-6 items-stretch">
          <div class="reveal card rounded-[2rem] overflow-hidden relative min-h-[560px] media"><img src="assets/highrise.jpg" class="absolute inset-0 w-full h-full object-cover" alt="AI Homes high-rise visual">
            <div class="absolute inset-0 bg-gradient-to-t from-black via-black/25 to-transparent"></div>
            <div class="absolute inset-x-0 bottom-0 p-7 sm:p-10">
              <div class="text-xs uppercase tracking-[.25em] text-white/40">09 / Start a conversation</div>
              <h2 class="mt-3 text-4xl sm:text-6xl font-black tracking-[-.055em]">Make the next<br>move.</h2>
              <p class="mt-5 text-white/50 max-w-md">Share your requirement and choose what you want to know. </p>
            </div>
          </div>
          <div id="lead-form" class="reveal glass rounded-[2rem] p-6 sm:p-10 scroll-mt-28">
            <p class="text-violet-300 text-xs font-bold uppercase tracking-[.25em]">Enquiry</p>
            <h2 class="mt-4 text-3xl sm:text-5xl font-black tracking-[-.05em]">Tell us what<br>you need.</h2>
            <form id="leadForm" action="process-form.php" method="POST" class="mt-9 space-y-4">
              <input type="hidden" name="lead_form" value="1">
              <input type="hidden" name="form_source" value="contact_form">
              <!-- Honeypot -->
              <input type="text" name="website" tabindex="-1" autocomplete="off" aria-hidden="true" style="position:absolute;left:-9999px;width:1px;height:1px;opacity:0">
              <div>
                <label for="f-name" class="block text-xs uppercase tracking-widest text-white/40 mb-2">Full Name</label>
                <input type="text" id="f-name" name="name" placeholder="Your name"
                  required minlength="2" maxlength="80"
                  autocomplete="name" inputmode="text" aria-label="Full name"
                  class="w-full rounded-2xl bg-white/5 border border-white/10 px-5 py-4 outline-none focus:border-violet-300/50">
              </div>
              <div>
                <label for="f-phone" class="block text-xs uppercase tracking-widest text-white/40 mb-2">Mobile Number</label>
                <input type="tel" id="f-phone" name="phone" placeholder="9412234688"
                  required minlength="10" maxlength="10"
                  autocomplete="tel" inputmode="tel" aria-label="Phone number"
                  pattern="[6-9][0-9]{9}"
                  class="w-full rounded-2xl bg-white/5 border border-white/10 px-5 py-4 outline-none focus:border-violet-300/50">
              </div>
              <div>
                <label for="f-email" class="block text-xs uppercase tracking-widest text-white/40 mb-2">Email Address</label>
                <input type="email" id="f-email" name="email" placeholder="you@email.com"
                  required maxlength="120"
                  autocomplete="email" inputmode="email" aria-label="Email address"
                  class="w-full rounded-2xl bg-white/5 border border-white/10 px-5 py-4 outline-none focus:border-violet-300/50">
              </div>
              <button class="btn w-full rounded-2xl bg-white text-black font-black py-4" type="submit">Send enquiry ↗</button>
              <p id="leadFormStatus" class="text-xs text-white/25 text-center" role="status" aria-live="polite"></p>
            </form>
          </div>
        </div>
      </div>
    </section>
  </main>

  <footer class="border-t border-white/5 py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 flex flex-col md:flex-row items-start md:items-center justify-between gap-5">
      <div>
        <div class="font-black">AI<span class="text-violet-300">.</span>HOMES</div>
        <div class="text-xs text-white/35 mt-2">AI Homes by Highlife • Greater Noida West</div>
      </div>
    </div>
  </footer>

  <a id="waFloat" target="_blank" aria-label="Open WhatsApp" href="<?= e(wa('Hi, I am interested in AI Homes by Highlife. Please share the latest details.')) ?>" class="float fixed z-40 right-4 bottom-4 sm:right-6 sm:bottom-6 btn w-14 h-14 flex items-center justify-center rounded-full bg-[#25D366] text-black shadow-2xl" title="Open WhatsApp"><svg width="27" height="27" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
      <path d="M20.5 3.5A11.9 11.9 0 0 0 12.03 0C5.47 0 .13 5.34.13 11.9c0 2.1.55 4.15 1.59 5.96L.03 24l6.28-1.65a11.85 11.85 0 0 0 5.72 1.46h.01c6.56 0 11.9-5.34 11.9-11.9 0-3.18-1.24-6.17-3.44-8.41Zm-8.47 18.3h-.01a9.86 9.86 0 0 1-5.02-1.38l-.36-.21-3.73.98 1-3.64-.23-.37a9.9 9.9 0 1 1 8.35 4.62Zm5.43-7.4c-.3-.15-1.78-.88-2.05-.98-.28-.1-.48-.15-.69.15-.2.3-.79.98-.97 1.18-.18.2-.36.23-.66.08-.3-.15-1.25-.46-2.39-1.47-.88-.78-1.47-1.74-1.64-2.04-.17-.3-.02-.46.13-.61.14-.14.3-.36.45-.54.15-.18.2-.31.3-.51.1-.2.05-.38-.03-.53-.08-.15-.69-1.66-.94-2.28-.25-.6-.5-.52-.69-.53h-.59c-.2 0-.53.08-.81.38-.28.3-1.06 1.04-1.06 2.54s1.09 2.95 1.24 3.15c.15.2 2.14 3.27 5.19 4.58.73.32 1.3.51 1.74.65.73.23 1.4.2 1.93.12.59-.09 1.78-.73 2.03-1.43.25-.7.25-1.3.18-1.43-.07-.13-.27-.2-.56-.35Z" />
    </svg></a>

  <script>window.SYNQIQ_ROOMS = <?= json_encode($rooms, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>;</script>
  <script src="js/main.js" defer></script>
</body>

</html>
