<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>StockSell ERP - Transformasi Kendali Bisnis Anda</title>
  <link rel="icon" type="image/png" href="https://img.icons8.com/color/48/000000/box.png">
  
  <!-- Premium Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,600&display=swap" rel="stylesheet">
  
  <!-- AOS Scroll Animation Library -->
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  
  <style>
    /* Premium CSS Variables for tailwind-like custom values & HSL colors */
    :root {
      --bg-dark: #070a13;
      --bg-card: rgba(255, 255, 255, 0.03);
      --bg-card-hover: rgba(255, 255, 255, 0.06);
      --border-color: rgba(255, 255, 255, 0.08);
      --border-hover: rgba(99, 102, 241, 0.4);
      --text-main: #f3f4f6;
      --text-muted: #9ca3af;
      --primary: #6366f1;
      --primary-glow: rgba(99, 102, 241, 0.15);
      --violet: #8b5cf6;
      --cyan: #22d3ee;
      --emerald: #34d399;
      --rose: #f43f5e;
      --amber: #f59e0b;
      --transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }

    /* Reset & Base Styles */
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      scroll-behavior: smooth;
    }

    body {
      background-color: var(--bg-dark);
      color: var(--text-main);
      font-family: 'Plus Jakarta Sans', sans-serif;
      overflow-x: hidden;
      line-height: 1.6;
    }

    /* Ambient Lighting Backgrounds */
    .glow-bg {
      position: absolute;
      width: 500px;
      height: 500px;
      border-radius: 50%;
      background: radial-gradient(circle, var(--primary-glow) 0%, transparent 70%);
      filter: blur(80px);
      z-index: -1;
      pointer-events: none;
    }

    .glow-1 { top: -100px; left: -100px; }
    .glow-2 { top: 600px; right: -200px; background: radial-gradient(circle, rgba(139, 92, 246, 0.1) 0%, transparent 75%); }
    .glow-3 { bottom: 100px; left: -200px; background: radial-gradient(circle, rgba(34, 211, 238, 0.08) 0%, transparent 75%); }

    /* Navigation Header */
    header {
      width: 100%;
      padding: 24px 8%;
      display: flex;
      justify-content: space-between;
      align-items: center;
      position: sticky;
      top: 0;
      background: rgba(7, 10, 19, 0.7);
      backdrop-filter: blur(20px);
      border-bottom: 1px solid var(--border-color);
      z-index: 100;
    }

    .logo-container {
      display: flex;
      align-items: center;
      gap: 12px;
      text-decoration: none;
    }

    .logo-box {
      width: 40px;
      height: 40px;
      background: linear-gradient(135deg, var(--primary) 0%, var(--violet) 100%);
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 800;
      color: white;
      font-size: 20px;
      box-shadow: 0 8px 24px rgba(99, 102, 241, 0.3);
    }

    .logo-text {
      font-size: 22px;
      font-weight: 800;
      color: white;
      letter-spacing: -0.5px;
    }

    .logo-badge {
      font-size: 9px;
      font-weight: 900;
      background: rgba(34, 211, 238, 0.15);
      color: var(--cyan);
      padding: 3px 8px;
      border-radius: 8px;
      text-transform: uppercase;
      letter-spacing: 1px;
    }

    .nav-links {
      display: flex;
      align-items: center;
      gap: 32px;
    }

    .nav-links a {
      color: var(--text-muted);
      text-decoration: none;
      font-weight: 600;
      font-size: 14px;
      transition: var(--transition);
    }

    .nav-links a:hover {
      color: white;
    }

    .btn-header {
      padding: 10px 22px;
      background: linear-gradient(135deg, var(--primary) 0%, var(--violet) 100%);
      color: white;
      border: none;
      border-radius: 12px;
      font-weight: 700;
      font-size: 13px;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      cursor: pointer;
      text-decoration: none;
      box-shadow: 0 4px 15px rgba(99, 102, 241, 0.2);
      transition: var(--transition);
    }

    .btn-header:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(99, 102, 241, 0.4);
    }

    /* Container Settings */
    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 24px;
      position: relative;
    }

    /* Hero Section */
    .hero {
      padding: 120px 0 80px 0;
      text-align: center;
      position: relative;
    }

    .hero-badge {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: rgba(255, 255, 255, 0.03);
      border: 1px solid var(--border-color);
      padding: 6px 16px;
      border-radius: 100px;
      font-size: 12px;
      font-weight: 600;
      color: var(--text-main);
      margin-bottom: 24px;
    }

    .hero-badge span {
      width: 6px;
      height: 6px;
      background-color: var(--emerald);
      border-radius: 50%;
      box-shadow: 0 0 10px var(--emerald);
    }

    .hero h1 {
      font-size: 58px;
      font-weight: 800;
      line-height: 1.15;
      letter-spacing: -2px;
      color: white;
      margin-bottom: 24px;
      max-width: 900px;
      margin-left: auto;
      margin-right: auto;
    }

    .hero h1 span {
      background: linear-gradient(135deg, var(--cyan) 0%, var(--primary) 50%, var(--violet) 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    .hero p {
      font-size: 18px;
      color: var(--text-muted);
      max-width: 650px;
      margin: 0 auto 40px auto;
      font-weight: 500;
    }

    .hero-ctas {
      display: flex;
      justify-content: center;
      gap: 16px;
      margin-bottom: 80px;
    }

    .btn-primary {
      padding: 16px 36px;
      background: linear-gradient(135deg, var(--primary) 0%, var(--violet) 100%);
      color: white;
      border: none;
      border-radius: 14px;
      font-size: 15px;
      font-weight: 700;
      cursor: pointer;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 10px;
      box-shadow: 0 10px 30px rgba(99, 102, 241, 0.25);
      transition: var(--transition);
    }

    .btn-primary:hover {
      transform: translateY(-3px);
      box-shadow: 0 15px 40px rgba(99, 102, 241, 0.4);
    }

    .btn-secondary {
      padding: 16px 36px;
      background: rgba(255, 255, 255, 0.03);
      color: white;
      border: 1px solid var(--border-color);
      border-radius: 14px;
      font-size: 15px;
      font-weight: 700;
      cursor: pointer;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 10px;
      transition: var(--transition);
    }

    .btn-secondary:hover {
      background: rgba(255, 255, 255, 0.08);
      border-color: rgba(255, 255, 255, 0.2);
      transform: translateY(-3px);
    }

    /* Mockup Showcase */
    .mockup-container {
      background: linear-gradient(135deg, rgba(255,255,255,0.05) 0%, rgba(255,255,255,0.01) 100%);
      border: 1px solid rgba(255,255,255,0.1);
      border-radius: 24px;
      padding: 8px;
      box-shadow: 0 40px 100px rgba(0,0,0,0.8), inset 0 1px 0 rgba(255,255,255,0.15);
      position: relative;
      overflow: hidden;
      transform: perspective(1000px) rotateX(5deg);
      transition: var(--transition);
    }

    .mockup-container:hover {
      transform: perspective(1000px) rotateX(0deg) translateY(-5px);
      border-color: rgba(99, 102, 241, 0.3);
    }

    .mockup-inner {
      background: #0f1322;
      border-radius: 18px;
      border: 1px solid rgba(255,255,255,0.05);
      overflow: hidden;
    }

    .mockup-header {
      background: #070a13;
      padding: 14px 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      border-bottom: 1px solid var(--border-color);
    }

    .mockup-dots {
      display: flex;
      gap: 8px;
    }

    .mockup-dot {
      width: 10px;
      height: 10px;
      border-radius: 50%;
    }

    .dot-red { background-color: var(--rose); }
    .dot-yellow { background-color: var(--amber); }
    .dot-green { background-color: var(--emerald); }

    .mockup-title {
      font-size: 11px;
      font-weight: 700;
      color: var(--text-muted);
      letter-spacing: 1px;
      text-transform: uppercase;
    }

    .mockup-badge {
      font-size: 10px;
      font-weight: 800;
      background: rgba(52, 211, 153, 0.15);
      color: var(--emerald);
      padding: 4px 10px;
      border-radius: 6px;
      display: flex;
      align-items: center;
      gap: 4px;
    }

    .mockup-content {
      padding: 30px;
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 20px;
      text-align: left;
    }

    /* Mockup Mini Cards */
    .mini-card {
      background: rgba(255,255,255,0.02);
      border: 1px solid rgba(255,255,255,0.05);
      border-radius: 16px;
      padding: 20px;
      position: relative;
    }

    .mini-card p {
      font-size: 10px;
      font-weight: 700;
      color: var(--text-muted);
      text-transform: uppercase;
      letter-spacing: 1px;
      margin-bottom: 4px;
    }

    .mini-card h3 {
      font-size: 24px;
      font-weight: 800;
      color: white;
    }

    .mini-card span {
      font-size: 9px;
      font-weight: 600;
      color: var(--emerald);
      background: rgba(52,211,153,0.1);
      padding: 2px 6px;
      border-radius: 4px;
      position: absolute;
      top: 20px;
      right: 20px;
    }

    .mockup-visuals {
      grid-column: span 4;
      display: grid;
      grid-template-columns: 2fr 1fr;
      gap: 20px;
      margin-top: 10px;
    }

    .mockup-chart-box {
      background: rgba(255,255,255,0.02);
      border: 1px solid rgba(255,255,255,0.05);
      border-radius: 20px;
      padding: 24px;
      min-height: 220px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }

    .chart-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
    }

    .chart-title {
      font-size: 13px;
      font-weight: 700;
      color: white;
      text-transform: uppercase;
    }

    .chart-svg {
      width: 100%;
      height: 140px;
    }

    .mockup-list-box {
      background: rgba(255,255,255,0.02);
      border: 1px solid rgba(255,255,255,0.05);
      border-radius: 20px;
      padding: 24px;
      display: flex;
      flex-direction: column;
      gap: 12px;
    }

    .list-item {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding-bottom: 12px;
      border-bottom: 1px solid rgba(255,255,255,0.05);
    }

    .list-item:last-child {
      border-bottom: none;
      padding-bottom: 0;
    }

    .item-name {
      font-size: 12px;
      font-weight: 700;
      color: white;
      text-transform: uppercase;
    }

    .item-sku {
      font-size: 10px;
      font-family: monospace;
      color: var(--text-muted);
    }

    .item-stock {
      font-size: 12px;
      font-weight: 800;
      color: var(--cyan);
    }

    /* Features Grid Section */
    .features {
      padding: 120px 0;
      position: relative;
    }

    .section-header {
      text-align: center;
      margin-bottom: 60px;
    }

    .section-header p {
      font-size: 11px;
      font-weight: 800;
      color: var(--primary);
      text-transform: uppercase;
      letter-spacing: 2px;
      margin-bottom: 16px;
    }

    .section-header h2 {
      font-size: 38px;
      font-weight: 800;
      color: white;
      letter-spacing: -1px;
    }

    .features-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 24px;
    }

    .feature-card {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      border-radius: 24px;
      padding: 32px;
      transition: var(--transition);
      position: relative;
      overflow: hidden;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      min-height: 320px;
    }

    .feature-card:hover {
      background: var(--bg-card-hover);
      border-color: var(--border-hover);
      transform: translateY(-5px);
      box-shadow: 0 20px 40px rgba(99, 102, 241, 0.1);
    }

    .feature-icon-box {
      width: 52px;
      height: 52px;
      border-radius: 14px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 30px;
    }

    .icon-admin { background: rgba(99, 102, 241, 0.1); color: var(--primary); }
    .icon-finance { background: rgba(52, 211, 153, 0.1); color: var(--emerald); }
    .icon-warehouse { background: rgba(34, 211, 238, 0.1); color: var(--cyan); }
    .icon-purchasing { background: rgba(245, 158, 11, 0.1); color: var(--amber); }

    .feature-card h3 {
      font-size: 20px;
      font-weight: 800;
      color: white;
      margin-bottom: 12px;
      letter-spacing: -0.5px;
    }

    .feature-card p {
      font-size: 13px;
      color: var(--text-muted);
      font-weight: 500;
      margin-bottom: auto;
    }

    .feature-role {
      font-size: 10px;
      font-weight: 800;
      color: white;
      opacity: 0.6;
      text-transform: uppercase;
      letter-spacing: 1px;
      margin-top: 24px;
    }

    /* Sleek Credentials / Terminals Block */
    .credentials {
      padding: 80px 0;
      position: relative;
    }

    .term-box {
      background: #090d1a;
      border: 1px solid var(--border-color);
      border-radius: 24px;
      overflow: hidden;
      box-shadow: 0 30px 70px rgba(0,0,0,0.5);
    }

    .term-header {
      background: #04060d;
      padding: 16px 24px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      border-bottom: 1px solid var(--border-color);
    }

    .term-badge {
      font-size: 11px;
      font-weight: 800;
      color: var(--primary);
      text-transform: uppercase;
      letter-spacing: 1px;
    }

    .term-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      padding: 40px;
      gap: 24px;
    }

    .term-card {
      background: rgba(255,255,255,0.02);
      border: 1px solid rgba(255,255,255,0.05);
      border-radius: 18px;
      padding: 24px;
      text-align: left;
      position: relative;
    }

    .term-card-role {
      font-size: 10px;
      font-weight: 800;
      color: var(--cyan);
      text-transform: uppercase;
      letter-spacing: 1px;
      margin-bottom: 16px;
      display: flex;
      align-items: center;
      gap: 6px;
    }

    .role-dot {
      width: 6px;
      height: 6px;
      border-radius: 50%;
    }

    .term-field {
      margin-bottom: 12px;
    }

    .term-label {
      font-size: 9px;
      font-weight: 700;
      color: var(--text-muted);
      text-transform: uppercase;
      letter-spacing: 0.5px;
      margin-bottom: 4px;
    }

    .term-value-group {
      display: flex;
      align-items: center;
      justify-content: space-between;
      background: rgba(0,0,0,0.2);
      border: 1px solid rgba(255,255,255,0.03);
      padding: 8px 12px;
      border-radius: 8px;
    }

    .term-value {
      font-size: 12px;
      font-family: monospace;
      font-weight: 700;
      color: white;
    }

    .btn-copy {
      background: none;
      border: none;
      color: var(--text-muted);
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: var(--transition);
    }

    .btn-copy:hover {
      color: white;
      transform: scale(1.1);
    }

    /* Toast Notification */
    .toast {
      position: fixed;
      bottom: 24px;
      right: 24px;
      background: rgba(99, 102, 241, 0.95);
      color: white;
      padding: 12px 24px;
      border-radius: 12px;
      font-size: 13px;
      font-weight: 700;
      box-shadow: 0 10px 30px rgba(99, 102, 241, 0.4);
      z-index: 1000;
      display: none;
      animation: fadeInUp 0.3s ease;
    }

    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    /* Setup Guide Grid */
    .setup-section {
      padding: 100px 0;
      position: relative;
    }

    .setup-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 32px;
      margin-top: 40px;
    }

    .setup-step {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      border-radius: 24px;
      padding: 32px;
      position: relative;
      transition: var(--transition);
    }

    .setup-step:hover {
      border-color: rgba(99, 102, 241, 0.2);
    }

    .step-number {
      font-size: 36px;
      font-weight: 900;
      background: linear-gradient(135deg, var(--cyan) 0%, var(--primary) 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      margin-bottom: 20px;
      display: block;
    }

    .setup-step h3 {
      font-size: 18px;
      font-weight: 800;
      color: white;
      margin-bottom: 12px;
    }

    .setup-step p {
      font-size: 13px;
      color: var(--text-muted);
      font-weight: 500;
    }

    /* Footer */
    footer {
      border-top: 1px solid var(--border-color);
      padding: 40px 0;
      text-align: center;
      background: #04060d;
    }

    footer p {
      font-size: 13px;
      color: var(--text-muted);
      font-weight: 500;
    }

    footer strong {
      color: white;
    }

    /* Software Grid Styles */
    .software-section {
      padding: 60px 0 100px 0;
      position: relative;
    }

    .software-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 24px;
      margin-top: 40px;
    }

    .software-card {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      border-radius: 24px;
      padding: 28px;
      transition: var(--transition);
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      min-height: 280px;
    }

    .software-card:hover {
      background: var(--bg-card-hover);
      border-color: var(--border-hover);
      transform: translateY(-5px);
      box-shadow: 0 20px 40px rgba(99, 102, 241, 0.1);
    }

    .software-logo {
      width: 48px;
      height: 48px;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 20px;
      background: rgba(255,255,255,0.03);
      border: 1px solid rgba(255,255,255,0.05);
    }

    .software-card h3 {
      font-size: 18px;
      font-weight: 800;
      color: white;
      margin-bottom: 8px;
    }

    .software-card p {
      font-size: 12px;
      color: var(--text-muted);
      margin-bottom: 24px;
      line-height: 1.5;
    }

    .btn-download {
      width: 100%;
      padding: 10px;
      background: rgba(99, 102, 241, 0.1);
      color: var(--primary);
      border: 1px solid rgba(99, 102, 241, 0.2);
      border-radius: 12px;
      font-size: 12px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      text-align: center;
      text-decoration: none;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      transition: var(--transition);
    }

    .btn-download:hover {
      background: linear-gradient(135deg, var(--primary) 0%, var(--violet) 100%);
      color: white;
      border-color: transparent;
      box-shadow: 0 8px 20px rgba(99, 102, 241, 0.3);
    }

    /* Documentation-style Setup Layout */
    .docs-section {
      padding: 100px 0;
      position: relative;
    }

    .docs-container {
      background: rgba(9, 13, 26, 0.4);
      border: 1px solid var(--border-color);
      border-radius: 28px;
      overflow: hidden;
      display: grid;
      grid-template-columns: 1.2fr 1fr;
      margin-top: 40px;
      backdrop-filter: blur(20px);
      box-shadow: 0 40px 100px rgba(0, 0, 0, 0.6);
    }

    .docs-content {
      padding: 48px;
      border-right: 1px solid var(--border-color);
    }

    .docs-steps {
      display: flex;
      flex-direction: column;
      gap: 36px;
    }

    .docs-step {
      position: relative;
      padding-left: 48px;
    }

    .docs-step::before {
      content: "";
      position: absolute;
      left: 18px;
      top: 32px;
      bottom: -48px;
      width: 1px;
      background: linear-gradient(180deg, var(--primary) 0%, rgba(99, 102, 241, 0) 100%);
    }

    .docs-step:last-child::before {
      display: none;
    }

    .docs-step-num {
      position: absolute;
      left: 0;
      top: 0;
      width: 36px;
      height: 36px;
      border-radius: 50%;
      background: rgba(99, 102, 241, 0.1);
      border: 1px solid rgba(99, 102, 241, 0.3);
      color: var(--primary);
      font-size: 14px;
      font-weight: 800;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 0 15px rgba(99, 102, 241, 0.2);
    }

    .docs-step h3 {
      font-size: 18px;
      font-weight: 800;
      color: white;
      margin-bottom: 8px;
    }

    .docs-step p {
      font-size: 13px;
      color: var(--text-muted);
      line-height: 1.6;
    }

    .docs-step strong {
      color: white;
      font-weight: 700;
    }

    .docs-step-code-inline {
      font-family: monospace;
      background: rgba(255,255,255,0.06);
      padding: 2px 6px;
      border-radius: 4px;
      color: var(--cyan);
      font-size: 12px;
      border: 1px solid rgba(255,255,255,0.03);
    }

    .docs-terminal-panel {
      background: #04060d;
      padding: 48px;
      display: flex;
      flex-direction: column;
      gap: 28px;
      justify-content: center;
    }

    .docs-term-window {
      background: #090d1a;
      border: 1px solid rgba(255, 255, 255, 0.05);
      border-radius: 16px;
      overflow: hidden;
      box-shadow: 0 20px 40px rgba(0,0,0,0.4);
    }

    .docs-term-header {
      background: #060912;
      padding: 12px 18px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }

    .docs-term-title {
      font-size: 10px;
      font-family: monospace;
      color: var(--text-muted);
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .docs-term-body {
      padding: 20px;
      margin: 0;
      font-family: monospace;
      font-size: 12px;
      color: #38bdf8;
      line-height: 1.6;
      white-space: pre-wrap;
      position: relative;
    }

    .docs-term-body code {
      color: #38bdf8;
    }

    .docs-term-body .comment {
      color: #6b7280;
    }

    .docs-term-body .cmd {
      color: #e2e8f0;
    }

    .docs-btn-copy-code {
      position: absolute;
      top: 14px;
      right: 14px;
      background: rgba(255,255,255,0.03);
      border: 1px solid rgba(255,255,255,0.05);
      color: var(--text-muted);
      padding: 6px;
      border-radius: 6px;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: var(--transition);
    }

    .docs-btn-copy-code:hover {
      background: rgba(99, 102, 241, 0.15);
      border-color: rgba(99, 102, 241, 0.3);
      color: white;
    }

    /* Responsive Settings */
    @media (max-width: 1024px) {
      .features-grid, .term-grid, .setup-grid, .software-grid {
        grid-template-columns: repeat(2, 1fr);
      }
      .mockup-visuals {
        grid-template-columns: 1fr;
      }
      .docs-container {
        grid-template-columns: 1fr;
      }
      .docs-content {
        border-right: none;
        border-bottom: 1px solid var(--border-color);
      }
    }

    @media (max-width: 768px) {
      header {
        margin-bottom: 30px;
        padding: 15px 0;
      }
      .logo-text {
        font-size: 18px;
      }
      .logo-badge {
        display: none;
      }
      .hero {
        padding: 80px 0 40px 0;
      }
      .hero h1 {
        font-size: 34px;
        letter-spacing: -1px;
        line-height: 1.25;
      }
      .hero p {
        font-size: 15px;
        margin-bottom: 30px;
      }
      .hero-ctas {
        margin-bottom: 50px;
      }
      .features-grid, .term-grid, .setup-grid, .software-grid {
        grid-template-columns: 1fr;
      }
      .nav-links {
        display: none;
      }
    }

    @media (max-width: 480px) {
      .hero-ctas {
        flex-direction: column;
        gap: 12px;
        align-items: stretch;
      }
      .hero-ctas a {
        display: flex;
        justify-content: center;
        width: 100%;
        box-sizing: border-box;
      }
      .mockup-content {
        grid-template-columns: 1fr;
        padding: 15px;
      }
      .mini-card {
        padding: 16px;
      }
      .section-header h2 {
        font-size: 24px;
      }
    }
  </style>
</head>
<body>

  <!-- Ambient Glowing Blurs -->
  <div class="glow-bg glow-1"></div>
  <div class="glow-bg glow-2"></div>
  <div class="glow-bg glow-3"></div>

  <!-- Header Navigation -->
  <header>
    <a href="#" class="logo-container">
      <div class="logo-box">M</div>
      <span class="logo-text">Mesama</span>
      <span class="logo-badge">ERP Demo</span>
    </a>
    <div class="nav-links">
      <a href="#fitur">Fitur Utama</a>
      <a href="#kredensial">Akun Demo</a>
      <a href="#prasyarat">Daftar Software</a>
      <a href="#instalasi">Panduan Setup</a>
    </div>
    <a href="http://mesama.fikrisan.net/login" class="btn-header" target="_blank">Jalankan Demo</a>
  </header>

  <div class="container">
    
    <!-- Hero Section -->
    <section class="hero">
      <div class="hero-badge" data-aos="fade-down" data-aos-duration="600">
        <span></span>
        PT Mesama Global Indonesia
      </div>
      <h1 data-aos="fade-up" data-aos-delay="100">Sistem Informasi Manajemen Terintegrasi <span>StockSell ERP</span></h1>
      <p data-aos="fade-up" data-aos-delay="200">Solusi enterprise tangguh dengan kontrol akses berbasis peran (RBAC) yang presisi, dirancang untuk efisiensi rantai pasok, manajemen gudang, dan laporan finansial real-time.</p>
      
      <div class="hero-ctas" data-aos="fade-up" data-aos-delay="300">
        <a href="http://localhost:8000/login" class="btn-primary" target="_blank">
          Coba Demo Live
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
        </a>
        <a href="#instalasi" class="btn-secondary">
          Panduan Setup
        </a>
      </div>

      <!-- Mockup Showcase of ERP Dashboard -->
      <div class="mockup-container" data-aos="zoom-in-up" data-aos-delay="400" data-aos-duration="1000">
        <div class="mockup-inner">
          <div class="mockup-header">
            <div class="mockup-dots">
              <div class="mockup-dot dot-red"></div>
              <div class="mockup-dot dot-yellow"></div>
              <div class="mockup-dot dot-green"></div>
            </div>
            <div class="mockup-title">stocksell-erp_dashboard.html</div>
            <div class="mockup-badge">
              <span style="width:5px; height:5px; background:var(--emerald); border-radius:50%;"></span>
              System Live
            </div>
          </div>
          
          <div class="mockup-content">
            <div class="mini-card">
              <p>Total Produk</p>
              <h3>50</h3>
              <span style="background:rgba(99,102,241,0.1); color:var(--primary);">Pcs</span>
            </div>
            <div class="mini-card">
              <p>Kategori Aktif</p>
              <h3>5</h3>
              <span style="background:rgba(34,211,238,0.1); color:var(--cyan);">Katalog</span>
            </div>
            <div class="mini-card">
              <p>Volume Stok</p>
              <h3>5.846</h3>
              <span>Unit</span>
            </div>
            <div class="mini-card">
              <p>Stok Kritis</p>
              <h3 style="color:var(--emerald);">0</h3>
              <span style="background:rgba(52,211,153,0.1); color:var(--emerald);">Aman</span>
            </div>
            
            <div class="mockup-visuals">
              <div class="mockup-chart-box">
                <div class="chart-header">
                  <span class="chart-title">Analisis Stok per Kategori</span>
                  <span style="font-size:10px; color:var(--text-muted); font-weight:700;">Live Update</span>
                </div>
                <!-- Simulated Donut Chart using SVG -->
                <div style="display:flex; justify-content:center; align-items:center; height:100%;">
                  <svg width="180" height="180" viewBox="0 0 36 36">
                    <circle cx="18" cy="18" r="15.915" fill="none" stroke="#161b30" stroke-width="3"></circle>
                    <circle cx="18" cy="18" r="15.915" fill="none" stroke="var(--primary)" stroke-width="4.2" stroke-dasharray="35 65" stroke-dashoffset="25"></circle>
                    <circle cx="18" cy="18" r="15.915" fill="none" stroke="var(--cyan)" stroke-width="4.2" stroke-dasharray="25 75" stroke-dashoffset="90"></circle>
                    <circle cx="18" cy="18" r="15.915" fill="none" stroke="var(--emerald)" stroke-width="4.2" stroke-dasharray="20 80" stroke-dashoffset="65"></circle>
                    <circle cx="18" cy="18" r="15.915" fill="none" stroke="var(--violet)" stroke-width="4.2" stroke-dasharray="20 80" stroke-dashoffset="45"></circle>
                    <text x="18" y="16.5" text-anchor="middle" font-size="2" fill="var(--text-muted)" font-weight="800">UNIT TOTAL</text>
                    <text x="18" y="21.5" text-anchor="middle" font-size="4" fill="white" font-weight="900">5.846</text>
                  </svg>
                </div>
              </div>
              
              <div class="mockup-list-box">
                <div class="list-item">
                  <div>
                    <p class="item-name">Retinol Night Serum</p>
                    <span class="item-sku">MSM-FAC-001</span>
                  </div>
                  <span class="item-stock">86 Pcs</span>
                </div>
                <div class="list-item">
                  <div>
                    <p class="item-name">Vitamin C Concentrate</p>
                    <span class="item-sku">MSM-FAC-002</span>
                  </div>
                  <span class="item-stock">71 Pcs</span>
                </div>
                <div class="list-item">
                  <div>
                    <p class="item-name">Hyaluronic Acid 2%</p>
                    <span class="item-sku">MSM-FAC-003</span>
                  </div>
                  <span class="item-stock">59 Pcs</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="fitur">
      <div class="section-header" data-aos="fade-up">
        <p>Akses Multirole Berbasis Peran</p>
        <h2>4 Modul Operasional ERP Terintegrasi</h2>
      </div>

      <div class="features-grid">
        <!-- Card 1 -->
        <div class="feature-card" data-aos="fade-up" data-aos-delay="100">
          <div class="feature-icon-box icon-admin">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
          </div>
          <div>
            <h3>Supervisor Portal</h3>
            <p>Pengawasan master data produk, pembuatan invoice Sales Order (SO), manajemen otorisasi pengguna, dan pemantauan pergerakan inventaris secara real-time.</p>
          </div>
          <div class="feature-role">Role: Administrator</div>
        </div>

        <!-- Card 2 -->
        <div class="feature-card" data-aos="fade-up" data-aos-delay="200">
          <div class="feature-icon-box icon-finance">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
          </div>
          <div>
            <h3>Pusat Komando Keuangan</h3>
            <p>Pencatatan pembayaran atas invoice Sales Order (SO), otorisasi pembayaran ke supplier untuk Purchase Order (PO), serta dashboard arus kas keluar/masuk otomatis.</p>
          </div>
          <div class="feature-role">Role: Finance</div>
        </div>

        <!-- Card 3 -->
        <div class="feature-card" data-aos="fade-up" data-aos-delay="300">
          <div class="feature-icon-box icon-warehouse">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4a2 2 0 0 0 1-1.73z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/></svg>
          </div>
          <div>
            <h3>Logistik & Pergudangan</h3>
            <p>Pemberian konfirmasi stok fisik barang keluar untuk SO prabayar, penerimaan serta verifikasi barang masuk (PO) dari supplier, dan histori log mutasi stok.</p>
          </div>
          <div class="feature-role">Role: Warehouse</div>
        </div>

        <!-- Card 4 -->
        <div class="feature-card" data-aos="fade-up" data-aos-delay="400">
          <div class="feature-icon-box icon-purchasing">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
          </div>
          <div>
            <h3>Pengadaan Barang</h3>
            <p>Pengajuan pengadaan stok barang (Purchase Order/PO) baru ke supplier mitra terdaftar untuk mencegah terjadinya kekosongan persediaan logistik gudang.</p>
          </div>
          <div class="feature-role">Role: Purchasing</div>
        </div>
      </div>
    </section>

    <!-- Sleek Credentials Section -->
    <section class="credentials" id="kredensial">
      <div class="section-header" data-aos="fade-up">
        <p>Akses Cepat Pengujian</p>
        <h2>Kredensial Akun Live Demo</h2>
      </div>

      <div class="term-box" data-aos="zoom-in" data-aos-duration="1000">
        <div class="term-header">
          <div class="term-badge">Terminal Akses Kredensial</div>
          <div style="display:flex; gap:6px;">
            <span style="width:8px; height:8px; border-radius:50%; background:#333;"></span>
            <span style="width:8px; height:8px; border-radius:50%; background:#333;"></span>
          </div>
        </div>
        
        <div class="term-grid">
          <!-- Akun 1 -->
          <div class="term-card">
            <div class="term-card-role">
              <span class="role-dot" style="background-color: var(--primary);"></span>
              Administrator (Admin)
            </div>
            <div class="term-field">
              <div class="term-label">Email</div>
              <div class="term-value-group">
                <span class="term-value" id="email-admin">admin@mesama.com</span>
                <button class="btn-copy" onclick="copyText('email-admin')">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
                </button>
              </div>
            </div>
            <div class="term-field" style="margin-bottom: 0;">
              <div class="term-label">Password</div>
              <div class="term-value-group">
                <span class="term-value" id="pass-admin">password</span>
                <button class="btn-copy" onclick="copyText('pass-admin')">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
                </button>
              </div>
            </div>
          </div>

          <!-- Akun 2 -->
          <div class="term-card">
            <div class="term-card-role">
              <span class="role-dot" style="background-color: var(--emerald);"></span>
              Finance (Keuangan)
            </div>
            <div class="term-field">
              <div class="term-label">Email</div>
              <div class="term-value-group">
                <span class="term-value" id="email-finance">finance@mesama.com</span>
                <button class="btn-copy" onclick="copyText('email-finance')">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
                </button>
              </div>
            </div>
            <div class="term-field" style="margin-bottom: 0;">
              <div class="term-label">Password</div>
              <div class="term-value-group">
                <span class="term-value" id="pass-finance">password</span>
                <button class="btn-copy" onclick="copyText('pass-finance')">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
                </button>
              </div>
            </div>
          </div>

          <!-- Akun 3 -->
          <div class="term-card">
            <div class="term-card-role">
              <span class="role-dot" style="background-color: var(--cyan);"></span>
              Warehouse (Gudang)
            </div>
            <div class="term-field">
              <div class="term-label">Email</div>
              <div class="term-value-group">
                <span class="term-value" id="email-warehouse">warehouse@mesama.com</span>
                <button class="btn-copy" onclick="copyText('email-warehouse')">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
                </button>
              </div>
            </div>
            <div class="term-field" style="margin-bottom: 0;">
              <div class="term-label">Password</div>
              <div class="term-value-group">
                <span class="term-value" id="pass-warehouse">password</span>
                <button class="btn-copy" onclick="copyText('pass-warehouse')">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
                </button>
              </div>
            </div>
          </div>

          <!-- Akun 4 -->
          <div class="term-card">
            <div class="term-card-role">
              <span class="role-dot" style="background-color: var(--amber);"></span>
              Purchasing (Pembelian)
            </div>
            <div class="term-field">
              <div class="term-label">Email</div>
              <div class="term-value-group">
                <span class="term-value" id="email-purchasing">purchasing@mesama.com</span>
                <button class="btn-copy" onclick="copyText('email-purchasing')">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
                </button>
              </div>
            </div>
            <div class="term-field" style="margin-bottom: 0;">
              <div class="term-label">Password</div>
              <div class="term-value-group">
                <span class="term-value" id="pass-purchasing">password</span>
                <button class="btn-copy" onclick="copyText('pass-purchasing')">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Software Requirements Section -->
    <section class="software-section" id="prasyarat">
      <div class="section-header" data-aos="fade-up">
        <p>Software Prasyarat Pengembang</p>
        <h2>Alat & Tautan Unduhan Resmi</h2>
      </div>

      <div class="software-grid">
        <!-- Software 1 -->
        <div class="software-card" data-aos="fade-up" data-aos-delay="100">
          <div>
            <div class="software-logo" style="color: var(--emerald);">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="2" y="2" width="20" height="20" rx="4" /><line x1="6" y1="6" x2="18" y2="18" /><line x1="18" y1="6" x2="6" y2="18" /></svg>
            </div>
            <h3>XAMPP</h3>
            <p>Membungkus server lokal Apache, database MySQL/MariaDB, dan runtime interpreter PHP 8.1 / 8.2 secara otomatis untuk Windows.</p>
          </div>
          <a href="https://www.apachefriends.org/download.html" class="btn-download" target="_blank">
            Unduh XAMPP
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="8 17 12 21 16 17"/><line x1="12" y1="12" x2="12" y2="21"/><path d="M20.88 18.04A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.29"/></svg>
          </a>
        </div>

        <!-- Software 2 -->
        <div class="software-card" data-aos="fade-up" data-aos-delay="200">
          <div>
            <div class="software-logo" style="color: var(--cyan);">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 10h-1.26A8 8 0 1 0 9 20h9a5 5 0 0 0 0-10z"/></svg>
            </div>
            <h3>Node.js & npm</h3>
            <p>Runtime engine JavaScript yang diperlukan untuk mengeksekusi bundler **Vite** dan memproses aset-aset modul tampilan antarmuka.</p>
          </div>
          <a href="https://nodejs.org/en/download/" class="btn-download" target="_blank">
            Unduh Node.js
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="8 17 12 21 16 17"/><line x1="12" y1="12" x2="12" y2="21"/><path d="M20.88 18.04A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.29"/></svg>
          </a>
        </div>

        <!-- Software 3 -->
        <div class="software-card" data-aos="fade-up" data-aos-delay="300">
          <div>
            <div class="software-logo" style="color: var(--primary);">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
            </div>
            <h3>Composer</h3>
            <p>Manajer dependensi package manager untuk ekosistem bahasa pemrograman PHP (mengunduh pustaka utama Laravel).</p>
          </div>
          <a href="https://getcomposer.org/download/" class="btn-download" target="_blank">
            Unduh Composer
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="8 17 12 21 16 17"/><line x1="12" y1="12" x2="12" y2="21"/><path d="M20.88 18.04A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.29"/></svg>
          </a>
        </div>
      </div>
    </section>

    <!-- Docs Section (Setup Guide) -->
    <section class="docs-section" id="instalasi">
      <div class="section-header" data-aos="fade-up">
        <p>Developer Documentation</p>
        <h2>Panduan Langkah Instalasi & Setup</h2>
      </div>

      <div class="docs-container">
        <!-- Left Side: Interactive Step-by-Step Description -->
        <div class="docs-content" data-aos="fade-right" data-aos-delay="100">
          <div class="docs-steps">
            <!-- Step 1 -->
            <div class="docs-step">
              <span class="docs-step-num">1</span>
              <h3>Arahkan Folder Proyek</h3>
              <p>Pastikan Anda telah memasang **XAMPP**. Buka terminal/command prompt, arahkan ke direktori root web server XAMPP Anda (default di <span class="docs-step-code-inline">C:\xampp\htdocs\</span>), lalu letakkan folder source code proyek ini di dalam folder tersebut.</p>
            </div>

            <!-- Step 2 -->
            <div class="docs-step">
              <span class="docs-step-num">2</span>
              <h3>Konfigurasi Basis Data & Environment</h3>
              <p>Buka XAMPP Control Panel lalu aktifkan module **Apache** dan **MySQL**. Akses <span class="docs-step-code-inline">http://localhost/phpmyadmin/</span> melalui browser untuk membuat basis data kosong baru bernama <strong style="color:var(--cyan);">stocksell_db</strong>. Salin berkas <span class="docs-step-code-inline">.env.example</span> menjadi <span class="docs-step-code-inline">.env</span> dan sesuaikan konfigurasi basis data Anda.</p>
            </div>

            <!-- Step 3 -->
            <div class="docs-step">
              <span class="docs-step-num">3</span>
              <h3>Instalasi Dependensi & Migrasi Data</h3>
              <p>Jalankan perintah pengelola pustaka PHP <span class="docs-step-code-inline">composer install</span> untuk mengunduh modul Laravel, dilanjutkan dengan <span class="docs-step-code-inline">npm install</span> untuk dependensi tampilan. Jalankan perintah migrasi basis data serta data seeder awal dengan mengetikkan perintah migrasi terpadu di terminal.</p>
            </div>

            <!-- Step 4 -->
            <div class="docs-step">
              <span class="docs-step-num">4</span>
              <h3>Jalankan Server Web Lokal</h3>
              <p>Setelah database terkonfigurasi, jalankan perintah <span class="docs-step-code-inline">php artisan serve</span> untuk mengaktifkan web server aplikasi PHP lokal, serta buka terminal baru untuk menjalankan bundler aset visual real-time menggunakan perintah <span class="docs-step-code-inline">npm run dev</span>.</p>
            </div>
          </div>
        </div>

        <!-- Right Side: Beautiful Floating Terminals -->
        <div class="docs-terminal-panel" data-aos="fade-left" data-aos-delay="150">
          <!-- Code Block 1 -->
          <div class="docs-term-window">
            <div class="docs-term-header">
              <span class="docs-term-title">Kloning & Setup Proyek</span>
              <div style="display:flex; gap:5px;">
                <span style="width:6px; height:6px; border-radius:50%; background:#ef4444;"></span>
                <span style="width:6px; height:6px; border-radius:50%; background:#eab308;"></span>
                <span style="width:6px; height:6px; border-radius:50%; background:#22c55e;"></span>
              </div>
            </div>
            <pre class="docs-term-body"><button class="docs-btn-copy-code" onclick="copyRawText('cmd-step1')"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg></button><code id="cmd-step1"><span class="comment"># Arahkan terminal ke htdocs XAMPP</span>
<span class="cmd">cd C:\xampp\htdocs</span>

<span class="comment"># Salin berkas konfigurasi .env</span>
<span class="cmd">copy .env.example .env</span></code></pre>
          </div>

          <!-- Code Block 2 -->
          <div class="docs-term-window">
            <div class="docs-term-header">
              <span class="docs-term-title">Dependensi & Basis Data</span>
              <div style="display:flex; gap:5px;">
                <span style="width:6px; height:6px; border-radius:50%; background:#ef4444;"></span>
                <span style="width:6px; height:6px; border-radius:50%; background:#eab308;"></span>
                <span style="width:6px; height:6px; border-radius:50%; background:#22c55e;"></span>
              </div>
            </div>
            <pre class="docs-term-body"><button class="docs-btn-copy-code" onclick="copyRawText('cmd-step2')"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg></button><code id="cmd-step2"><span class="comment"># Pasang dependensi PHP & JS</span>
<span class="cmd">composer install</span>
<span class="cmd">npm install</span>

<span class="comment"># Generate application key Laravel</span>
<span class="cmd">php artisan key:generate</span>

<span class="comment"># Jalankan migrasi basis data & seeder</span>
<span class="cmd">php artisan migrate:fresh --seed</span></code></pre>
          </div>

          <!-- Code Block 3 -->
          <div class="docs-term-window">
            <div class="docs-term-header">
              <span class="docs-term-title">Jalankan Server Lokal</span>
              <div style="display:flex; gap:5px;">
                <span style="width:6px; height:6px; border-radius:50%; background:#ef4444;"></span>
                <span style="width:6px; height:6px; border-radius:50%; background:#eab308;"></span>
                <span style="width:6px; height:6px; border-radius:50%; background:#22c55e;"></span>
              </div>
            </div>
            <pre class="docs-term-body"><button class="docs-btn-copy-code" onclick="copyRawText('cmd-step3')"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg></button><code id="cmd-step3"><span class="comment"># Jalankan server aplikasi utama PHP</span>
<span class="cmd">php artisan serve</span>

<span class="comment"># Jalankan server tampilan Vite (Terminal Baru)</span>
<span class="cmd">npm run dev</span></code></pre>
          </div>
        </div>
      </div>
    </section>

  </div>

  <!-- Footer -->
  <footer>
    <div class="container">
      <p>&copy; 2026 PT Mesama Global Indonesia. Seluruh hak cipta dilindungi undang-undang.</p>
      <p style="font-size:11px; margin-top:6px; color:rgba(255,255,255,0.3);">Dirancang secara premium menggunakan standar <strong>Digituhub Style</strong>.</p>
    </div>
  </footer>

  <!-- Copied Alert Toast Box -->
  <div class="toast" id="toast">Berhasil disalin ke clipboard!</div>

  <script>
    function copyText(elementId) {
      const textToCopy = document.getElementById(elementId).innerText;
      
      // Modern Clipboard API
      navigator.clipboard.writeText(textToCopy).then(() => {
        const toast = document.getElementById('toast');
        toast.innerText = 'Kredensial berhasil disalin ke clipboard!';
        toast.style.display = 'block';
        
        setTimeout(() => {
          toast.style.display = 'none';
        }, 2000);
      }).catch(err => {
        console.error('Gagal menyalin teks: ', err);
      });
    }

    function copyRawText(elementId) {
      const textToCopy = document.getElementById(elementId).innerText;
      
      // Modern Clipboard API
      navigator.clipboard.writeText(textToCopy).then(() => {
        const toast = document.getElementById('toast');
        toast.innerText = 'Perintah berhasil disalin ke clipboard!';
        toast.style.display = 'block';
        
        setTimeout(() => {
          toast.style.display = 'none';
        }, 2000);
      }).catch(err => {
        console.error('Gagal menyalin teks: ', err);
      });
    }
  </script>
  <!-- AOS Scroll Animation JS Library & Initialisation -->
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script>
    AOS.init({
      duration: 1000,
      once: true,
      easing: 'ease-out-cubic',
      delay: 50,
    });
  </script>
</body>
</html>
