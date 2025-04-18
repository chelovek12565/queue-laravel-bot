import './bootstrap';

const tg = window.Telegram.WebApp;
    const theme = tg.themeParams || {};

    document.documentElement.style.setProperty('--tg-bg-color', theme.bg_color || '#ffffff');
    document.documentElement.style.setProperty('--tg-text-color', theme.text_color || '#000000');
    document.documentElement.style.setProperty('--tg-hint-color', theme.hint_color || '#888888');
    document.documentElement.style.setProperty('--tg-link-color', theme.link_color || '#1d72f3');
 
