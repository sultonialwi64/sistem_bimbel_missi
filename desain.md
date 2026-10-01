# LuminaEdu Landing Page - Design System & Documentation

## 1. Design Typology

### Style Classification
- **Primary Style**: Neo-Brutalism + Editorial Design
- **Secondary Style**: Retro/Vintage (Y2K inspired accents)
- **Tone**: Playful, Energetic, Professional, Educational
- **Target Audience**: High school students, SMP students, parents, educators

### Design Philosophy
Memadukan disiplin akademik dengan kegembiraan eksplorasi. Desain yang tidak membosankan, visual yang memiliki karakter kuat, bukan AI slop—setiap elemen punya tujuan dan personality.

---

## 2. Color Palette

### Primary Colors
| Color | Hex | Usage | Purpose |
|-------|-----|-------|---------|
| Electric Blue | `#2563eb` | Primary CTA, active states | Main action & emphasis |
| Acid Lime | `#d9f99d` | Accent badges, highlights | Energy & playfulness |
| Vivid Amber | `#fbbf24` | Secondary accent | Warmth & friendliness |
| Neon Pink | `#f43f5e` | Tertiary accent, badges | Modern pop & urgency |
| Dark Ink | `#0f172a` | Text, borders, shadows | Primary text & structure |

### Secondary Colors
| Color | Hex | Usage |
|-------|-----|-------|
| Retro Cream | `#fffbeb` | Background soft sections |
| Secondary Container | `#d4f01e` | Lime-green highlights |
| Tertiary Fixed | `#ffddb8` | Warm orange accent |
| Neon Lilac | `#c084fc` | Future accent option |

### Neutral Palette
| Color | Hex | Usage |
|-------|-----|-------|
| White | `#ffffff` | Card backgrounds, text areas |
| Slate 100 | `#f3f4f6` | Light backgrounds |
| Slate 500 | `#6b7280` | Muted text |
| Slate 700 | `#374151` | Secondary text |

---

## 3. Typography System

### Font Families

#### Headline Font
- **Family**: Syne (Google Fonts)
- **Weights**: 700, 800
- **Usage**: H1, H2, H3, major headings
- **Characteristics**: Bold, geometric, modern sans-serif dengan personality kuat

#### Body Font
- **Family**: Plus Jakarta Sans (Google Fonts)
- **Weights**: 400, 500, 600, 700, 800
- **Usage**: Body text, paragraphs, descriptions
- **Characteristics**: Friendly, slightly rounded, highly readable

#### Label/Badge Font
- **Family**: Space Grotesk (Google Fonts)
- **Weights**: 500, 700
- **Usage**: Labels, badges, small caps text
- **Characteristics**: Monospace-inspired, technical feel

#### Editorial Font
- **Family**: EB Garamond (Google Fonts)
- **Weights**: 500, 700 (italic)
- **Usage**: Testimonials, quotes, special emphasis
- **Characteristics**: Serif elegance, editorial voice

### Type Scale

```
Display/Hero (H1)
- Font: Syne 800
- Size: 3.5rem (mobile) → 6rem (desktop)
- Line Height: 1.08
- Letter Spacing: tight

Headline Large (H2)
- Font: Syne 700
- Size: 3rem (mobile) → 5rem (desktop)
- Line Height: 1.2

Headline Medium (H3)
- Font: Syne 700
- Size: 1.3rem
- Line Height: 1.3

Body Large
- Font: Plus Jakarta Sans 400/500
- Size: 1.2rem
- Line Height: 1.6

Body Medium (default)
- Font: Plus Jakarta Sans 400
- Size: 1rem
- Line Height: 1.6

Body Small
- Font: Plus Jakarta Sans 400
- Size: 0.875rem
- Line Height: 1.5

Label
- Font: Space Grotesk 700
- Size: 0.75rem
- Letter Spacing: 0.15em
- Text Transform: uppercase
```

---

## 4. Neo-Brutalism Design Elements

### Core Principles

#### 1. **Hard Shadows**
```css
.brutal-shadow {
  box-shadow: 4px 4px 0px #0f172a;
}
.brutal-shadow-lg {
  box-shadow: 6px 6px 0px #0f172a;
}
.brutal-shadow-xl {
  box-shadow: 8px 8px 0px #0f172a;
}
```
- Offset shadows (tidak soft/blurred)
- Black/dark-ink color (#0f172a)
- Creates depth & physical presence
- On hover: shadows reduce (transform: translate(2px, 2px))

#### 2. **Thick Borders**
- Default: `border-2` (8px equivalent)
- Heavy: `border-4` (16px equivalent)
- Color: Dark Ink (#0f172a) atau accent color
- Creates strong visual separation & definition

#### 3. **Grid & Pattern Background**
```css
.bg-grid-pattern {
  background-image: 
    linear-gradient(to right, rgba(15, 23, 42, 0.07) 1px, transparent 1px),
    linear-gradient(to bottom, rgba(15, 23, 42, 0.07) 1px, transparent 1px);
  background-size: 28px 28px;
}

.bg-dot-pattern {
  background-image: radial-gradient(rgba(15, 23, 42, 0.15) 1.5px, transparent 1.5px);
  background-size: 18px 18px;
}
```
- Subtle grid/dot patterns behind content
- Adds texture & visual interest
- Low opacity (7-15%) agar tidak overwhelming

#### 4. **Geometric Shapes**
- Squares & rectangles dominan
- Rounded corners: `rounded-xl` (12px), `rounded-2xl` (16px)
- NO excessive border-radius (avoid 50px+)
- Maintains block/structural feel

#### 5. **Color Blocking**
- Bold, solid color backgrounds
- Stark contrast (dark + neon accent)
- Minimal gradients (hanya di hero CTA buttons)
- Clean separation antar zones

### Brutalist Components

#### Cards
```html
<div class="p-6 rounded-2xl bg-white border-2 border-dark-ink brutal-shadow-lg">
  <!-- Content -->
</div>
```
- White atau light background
- 2px border dark-ink
- 6px shadow offset
- Padding 1.5rem-2rem
- No rounded corners >16px

#### Buttons
```html
<!-- Primary -->
<button class="px-7 py-4 rounded-xl bg-electric-blue text-white border-2 border-dark-ink brutal-shadow-lg">
  Action Label
</button>

<!-- Secondary -->
<button class="px-6 py-4 rounded-xl bg-white text-dark-ink border-2 border-dark-ink brutal-shadow">
  Secondary Action
</button>
```
- Chunky padding (1rem+)
- Square corners (8-12px max)
- Heavy border + shadow
- On hover: shadow reduces, slight translate down

#### Badges & Pills
```html
<span class="px-3 py-1.5 rounded-lg bg-secondary-container text-dark-ink font-mono text-xs font-black border-2 border-dark-ink brutal-shadow">
  BADGE TEXT
</span>
```
- Compact & playful
- Solid color backgrounds
- 2px border
- 2-4px shadow

---

## 5. Retro/Vintage Elements

### Tape Effect
```css
.tape-effect::after {
  content: '';
  position: absolute;
  top: -12px;
  left: 30%;
  width: 80px;
  height: 24px;
  background: rgba(254, 240, 138, 0.85);
  border: 1px dashed rgba(15, 23, 42, 0.3);
  transform: rotate(-3deg);
}
```
- Yellow dashed tape on photo frames
- Creates nostalgic, analog feel
- Rotated slightly (-3deg)
- Positioned absolutely above cards

### Polaroid Aesthetic
- Cards with white border (p-3 pb-5)
- Photo area dengan aspect ratio [4/3] atau [4/4]
- Caption text bawah (monospace, small)
- Slight rotation (-2deg, 1.5deg, 2deg)
- Shadow untuk depth

### Floating Stickers/Stamps
```html
<div class="absolute top-8 left-8 rotate-[-6deg] z-20 pointer-events-none">
  <div class="px-3.5 py-1.5 rounded-full bg-acid-lime border-2 border-dark-ink brutal-shadow">
    [ SYSTEM: ACTIVE / 2025 ]
  </div>
</div>
```
- Absolutely positioned playful elements
- Rotated (-6deg, 8deg, 4deg)
- High z-index agar di atas content
- Pointer-events-none agar tidak blocking

### Marquee Ticker
```css
@keyframes marquee {
  0% { transform: translateX(0%); }
  100% { transform: translateX(-50%); }
}
.animate-marquee {
  animation: marquee 25s linear infinite;
}
```
- Endless scrolling text
- Pada header top bar
- Repeated content untuk seamless loop
- Creates sense of urgency & movement

---

## 6. Layout System

### Grid Structure
- **Max Width**: 1340px (max-w-[1340px])
- **Padding**: 1rem (mobile) → 2rem (desktop, px-8)
- **Gutter**: 2rem (gap-8) untuk section spacing
- **Responsive**: 1 col (mobile) → 2-3 cols (tablet) → 4 cols (desktop)

### Spacing Scale
```
2xs: 4px (0.25rem)
xs:  8px (0.5rem)
sm:  12px (0.75rem)
md:  16px (1rem)
lg:  24px (1.5rem)
xl:  32px (2rem)
2xl: 48px (3rem)
3xl: 64px (4rem)
```

### Section Spacing
- **Padding**: `py-20 md:py-28` (5rem mobile, 7rem desktop)
- **Border Bottom**: `border-b-2 border-dark-ink` between sections
- **Background**: Alternates (background, white, cream, dark-ink)

### Component Padding
- Cards: `p-6` to `p-8`
- Large cards: `p-8 md:p-10`
- Small elements: `p-3` to `p-4`

---

## 7. Component Library

### Hero Section
- **Layout**: Grid 7-5 (text left, visual right)
- **Background**: `bg-retro-cream/40` dengan overlay blobs
- **Main CTA**: Electric blue, brutal shadow-lg
- **Secondary CTA**: White dengan border
- **Social Proof**: 3-4 micro-cards dengan avatars & stats
- **Floating Elements**: Tutor card, gamification badge, schedule tag

### Feature/Pillar Cards
```
- 4 column grid (1 col mobile)
- bg-white, border-2 dark-ink
- Icon 14px x 14px, rounded-xl, colored background
- Title: Headline SM, bold
- Description: Body SM, muted
- Separator: border-t-2 dashed
- Footer badge: small rounded label
- Hover: rotate(-1deg) or rotate(1deg)
```

### Program/Pricing Cards
```
- Header section with gradient background
- Program name + icon
- Price display (large, bold)
- Feature list dengan checkboxes
- CTA button full width
- Bottom footer dengan pricing info
```

### Testimonial Cards
```
- Background: light color (cream, lime, etc)
- Star rating (5x filled stars)
- Badge top-right (achievement/status)
- Quote text: EB Garamond italic
- Score/metric highlight card
- Avatar + name + credential bawah
- Slight rotation on hover
```

### CTA Section (Large)
```
- Full width container
- Gradient background (electric-blue → neon-pink)
- Large h2 heading (white text)
- Subtext + benefits list
- Form atau big button
- Often dengan watermark text background (semi-transparent)
```

### Navigation Bar
- **Position**: sticky top-0 z-50
- **Background**: bg-background/95 backdrop-blur-md
- **Border**: border-b-2 border-dark-ink
- **Logo**: Flex gap-3, bordered pill style
- **Nav Pills**: Rounded-xl, active state electric-blue
- **CTAs**: Secondary-container (lime) + Electric blue

---

## 8. Interactive States

### Hover Effects
```css
.brutal-shadow-hover:hover {
  transform: translate(2px, 2px);
  box-shadow: 2px 2px 0px #0f172a;
}
```
- Shadow reduces (creates "press" effect)
- Slight translate down/right (2px)
- Quick transition (0.15s ease-in-out)

### Active/Focus States
- Button active: bg-electric-blue, text-white, scale slightly
- Navigation link: border bottom or different background
- Form input: focus:bg-white, focus:border-electric-blue

### Animation
- **Marquee**: 25s linear infinite (ticker)
- **Ping**: animate-ping on live badges (pulsing dot)
- **Rotation**: Slight rotate on cards (-1deg to 2deg) on hover
- **Slide**: Cards slide up on scroll (AOS library)

---

## 9. Imagery & Illustrations

### Photo Treatment
- All images dalam rounded-2xl containers
- Border-2 border-dark-ink
- Brutal shadow (4-6px offset)
- Aspect ratios: [4/3], [4/4], [16/9]
- Polaroid frames: white pb-5, caption monospace bawah

### Illustration Style
- Avoid: Gradient soft renders, realistic illustrations
- Use: Bold graphic icons, geometric shapes, line art
- Color: Solid blocks dari palette (not airbrushed)
- Consistency: Flat design atau simple 2D isometric

### Icon Library
- Google Material Symbols Outlined
- Size: 1.5rem to 3rem depending on context
- Color: Match content (primary color, white, dark-ink)
- Weight: Consistent dengan design

---

## 10. Accessibility & Performance

### Accessibility
- All images: `data-alt` descriptive text
- Color contrast: WCAG AA minimum
- Form labels: `<label>` tags, clear hierarchy
- Interactive: Sufficient click targets (44px min)
- Focus states: Visible outline atau color change

### Performance
- Tailwind CSS utility-first (optimized bundle)
- Images: External hosted (Google Drive via lh3.googleusercontent.com)
- No heavy animations on scroll (AOS with once:true)
- SVG icons (Material Symbols Outlined)
- Minimal custom CSS

### Mobile Responsiveness
- Breakpoints: sm (640px), md (768px), lg (1024px), xl (1280px)
- Grid: 1 col mobile, 2 col tablet, 4 col desktop
- Font sizes: Smaller mobile, scale up desktop
- Padding: Less padding mobile, more spacious desktop
- Navigation: Hidden on mobile (hamburger menu not implemented in this version)

---

## 11. Design Patterns

### Section Pattern
```
Header (inline flex, gap-2, badge + heading)
↓
Grid of cards/content (responsive columns)
↓
Bottom CTA atau transition element
↓
Border separator (border-b-2 border-dark-ink)
```

### Card Pattern
```
[Icon/Visual] ← top 12-14px
Title ← bold, headline-sm or md
Description ← body-sm, muted
Visual separator ← border-t dashed
Footer element ← badge atau stat
```

### CTA Pattern
```
Badge/label (small, uppercase, tight)
↓
Main headline (large, bold, rotated accent word)
↓
Supporting text (body-md, left border accent color)
↓
Dual CTAs (primary + secondary buttons)
↓
Social proof (avatars, ratings, stats)
```

---

## 12. Specific Sections Breakdown

### Ticker Header
- Full width, no padding sides
- Dark lime background (secondary-container)
- Border-b-2 dark-ink
- Marquee animation (infinite loop)
- Font-mono small, bold, uppercase
- Separator bullets between sections

### Hero Section
- `pt-12 pb-20 md:pt-18 md:pb-28`
- `bg-retro-cream/40` (soft cream)
- Floating playful elements (rotated badges)
- Floating SVG blobs (radial gradients, 15% opacity)
- Grid 7-5 layout
- Asymmetric floating cards (tutor, gamification, schedule)

### Credibility Section
- White background
- Dark header ribbon (dark-ink text, white text)
- 4-column stats grid
- Each stat: big number + description
- Hover effect: slight up translate

### Value Props (4 Pillar)
- Grid 1-2-4 (responsive)
- Each card: white bg, border-2
- Icon circle 14x14 (colored bg)
- Hover: rotate slight, scale icon
- Footer: colored badge + checkmark

### Programs Section
- Filter tabs (select level)
- 4-column grid (responsive)
- Each card: p-6, rounded-2xl
- One card "featured" (bg-secondary-container/30, ribbon badge)
- Header: gradient (different color per tier)
- Footer: pricing + CTA button

### Facilities/Polaroids
- Grid 2-2 (sm:2 cols, lg:2+2)
- Polaroid style (tape effect, rotation, shadow)
- Figure numbers + metadata
- Hover: slight rotation change

### Testimonials
- 3-column grid (responsive)
- Light background (cream, lime, lime)
- 5 stars rating
- Achievement badge top-right
- Quote: EB Garamond italic
- Score/metric highlight
- Avatar + name + credential

### Quiz CTA
- Dark blue background (electric-blue)
- Border-4 (heavy)
- Watermark text (large, semi-transparent)
- Grid 7-5 (text left, form right)
- Form card: white border-4, brutal shadow-lg

### Registration Form
- Large card border-4
- Dashed separator under header
- Form fields: grid 1-2 (responsive)
- Input: bg-slate-50, border-2, focus:bg-white
- Button: electric-blue, brutal shadow-lg
- Footer: small disclaimer text

### Footer
- Dark ink background (dark-ink)
- Border-t-4 heavy
- Grid 4-3-3-2 (large-md-md-sm cols)
- Social icon buttons (small, colored on hover)
- Bottom strip: copyright + links

---

## 13. Implementation Guidelines

### For New Projects Using This Design

#### Step 1: Setup
- Use Tailwind CSS + custom config
- Import same Google Fonts (Syne, Plus Jakarta Sans, Space Grotesk, EB Garamond)
- Add custom CSS for brutal shadows, patterns, animations

#### Step 2: Colors
- Define in tailwind.config.js extend colors
- Use consistent naming (primary, accent, dark-ink, etc)
- Maintain contrast ratio WCAG AA

#### Step 3: Typography
- Assign fonts per section (headlines = Syne, body = Plus Jakarta Sans)
- Use consistent scale (establish h1-h6, body sizes)
- Line height: headlines 1.08-1.3, body 1.5-1.6

#### Step 4: Components
- Create reusable card components
- Button system (primary, secondary, sizes)
- Badge/pill component
- Icon wrapper (colored bg circle)

#### Step 5: Layout
- Max-width container (1340px)
- Responsive padding (px-4 mobile, px-8 desktop)
- Section borders & spacing consistent
- Grid system: 1-2-4 columns responsive

#### Step 6: Interactions
- Add brutal-shadow-hover to clickable elements
- Hover transform (translate 2px, 2px)
- Focus states on form inputs
- Scroll animations (AOS library)

---

## 14. Do's & Don'ts

### ✅ DO
- Use solid, bold colors from palette
- Maintain 2px borders on cards
- Add offset shadows (hard shadows)
- Rotate elements slightly (-1 to 2 degrees)
- Use monospace fonts for labels/badges
- Keep typography hierarchy clear
- Use icons consistently
- Add whitespace generously

### ❌ DON'T
- Don't use soft/blurred shadows
- Don't exceed border-radius 16px on main elements
- Don't use pastel or washed-out colors
- Don't add too many animations
- Don't use serif fonts for body text
- Don't crowd components (maintain breathing room)
- Don't mix serif & sans-serif carelessly
- Don't use gradient backgrounds (except subtle, specific CTAs)

---

## 15. File Structure for Implementation

```
project/
├── index.html
├── styles/
│   ├── tailwind.config.js
│   └── custom.css (brutal shadows, patterns, animations)
├── components/
│   ├── card.html
│   ├── button.html
│   ├── badge.html
│   └── section-header.html
├── assets/
│   ├── images/
│   ├── icons/
│   └── fonts/
└── js/
    ├── animations.js
    ├── interactions.js
    └── form-handler.js
```

---

## 16. Customization Guide

### Color Swap
Replace palette hex values:
```
Electric Blue → Your primary color
Acid Lime → Your secondary accent
Neon Pink → Your tertiary accent
Dark Ink → Your dark/text color
```

### Typography Swap
Keep Syne (headlines) + Plus Jakarta Sans (body), change:
- Font sizes per breakpoint
- Line heights if needed
- Letter spacing for headlines

### Shadow Customization
Adjust offset based on design:
```css
/* Smaller offset */
box-shadow: 2px 2px 0px #0f172a;

/* Larger offset */
box-shadow: 8px 8px 0px #0f172a;

/* Colored shadow */
box-shadow: 6px 6px 0px #2563eb;
```

### Layout Adjustment
- Change max-width (1340px → 1200px, 1440px)
- Adjust grid columns (4 → 3, 2 → 5)
- Modify section padding (py-20 → py-16, py-24)

---

## 17. Resources & References

### External Libraries
- **Tailwind CSS**: https://tailwindcss.com/
- **Google Fonts**: Syne, Plus Jakarta Sans, Space Grotesk, EB Garamond
- **Material Symbols**: https://fonts.google.com/icons
- **AOS (Animate On Scroll)**: https://michalsnik.github.io/aos/

### Design Inspiration
- Neo-brutalism trend (2024-2025)
- Y2K retro aesthetic
- Editorial/magazine layouts
- Modern SaaS design patterns

### Tools Used in Creation
- Tailwind CSS (styling)
- HTML5 semantic markup
- CSS Grid & Flexbox
- Google Fonts API

---

## Final Notes

Design ini dirancang untuk **bimbel/education landing pages** tapi fleksibel untuk **SaaS, startup, agency** dengan menyesuaikan:
- Copy tone & messaging
- Color palette (sesuai brand)
- Imagery & testimonials
- Pricing structure
- CTA messaging

Semua komponen modular dan dapat direproduksi di project lain dengan mengikuti guidelines ini. Maintain konsistensi warna, typography, spacing, dan brutalist principles untuk hasil yang cohesive.

---

**Version**: 1.0  
**Last Updated**: October 2026  
**Design by**: LuminaEdu Team
