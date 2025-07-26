<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;
 ?>
<style>
    .spp-coming-soon-wrapper {
        background: #fff;
        border: 1px solid #ccd0d4;
        border-left: 4px solid #0073aa;
        padding: 20px;
        margin-top: 20px;
        border-radius: 6px;
        position: relative;
        overflow: hidden;
    }

    .spp-coming-soon-wrapper::after {
        content: "Live Preview";
        position: absolute;
        top: 10px;
        right: -50px;
        transform: rotate(45deg);
        background: #f39c12;
        color: #fff;
        padding: 5px 50px;
        font-weight: bold;
        font-size: 12px;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
    }

    .spp-coming-soon-title {
        font-size: 24px;
        font-weight: 600;
        margin-bottom: 10px;
        color: #23282d;
    }

    .spp-coming-soon-desc {
        font-size: 15px;
        color: #555d66;
    }

    .spp-coming-soon-badge {
        display: inline-block;
        margin-top: 15px;
        padding: 6px 12px;
        background: #00a0d2;
        color: #fff;
        font-weight: 500;
        border-radius: 20px;
        font-size: 13px;
        animation: glow 1.5s infinite alternate;
    }

    @keyframes glow {
        from {
            box-shadow: 0 0 5px #00a0d2;
        }
        to {
            box-shadow: 0 0 20px #00a0d2;
        }
    }

    .spp-coming-soon-preview {
        margin-top: 20px;
        padding: 20px;
        background: #f8f9fa;
        border: 1px dashed #ccd0d4;
        border-radius: 6px;
        color: #777;
        font-style: italic;
        text-align: center;
    }
</style>

<div class="spp-coming-soon-wrapper">
    <div class="spp-coming-soon-title">New Feature: Live Preview</div>
    <div class="spp-coming-soon-desc">
        We’re working on an exciting Live Preview Panel that will let you see your Table of Contents settings update in real-time — right inside the plugin!
        No more guesswork — you’ll be able to tweak and test with confidence before saving.
    </div>
    <div>🎯 Stay tuned — this feature is just around the corner!</div>
    <div class="spp-coming-soon-badge">Coming Soon</div>
    <div class="spp-coming-soon-preview">
        🔧 Live Preview Area Placeholder
    </div>
</div>
<?php