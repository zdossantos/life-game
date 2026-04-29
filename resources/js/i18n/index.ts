import { createI18n } from 'vue-i18n';
import en from './locales/en';
import fr from './locales/fr';

type MessageSchema = typeof en;

const LOCALE_KEY = 'locale';
const SUPPORTED_LOCALES = ['en', 'fr'] as const;
type SupportedLocale = (typeof SUPPORTED_LOCALES)[number];

/**
 * Detect the best locale to use:
 * 1. User-stored preference in localStorage
 * 2. Browser language (navigator.language)
 * 3. Fallback to English
 */
function detectLocale(): SupportedLocale {
    if (typeof window === 'undefined') return 'en';

    const stored = localStorage.getItem(LOCALE_KEY) as SupportedLocale | null;
    if (stored && SUPPORTED_LOCALES.includes(stored)) return stored;

    const browserLang = navigator.language?.split('-')[0] as SupportedLocale;
    if (SUPPORTED_LOCALES.includes(browserLang)) return browserLang;

    return 'en';
}

const initialLocale = detectLocale();

if (typeof window !== 'undefined') {
    document.documentElement.lang = initialLocale;
}

export const i18n = createI18n<[MessageSchema], SupportedLocale>({
    legacy: false,
    locale: initialLocale,
    fallbackLocale: 'en',
    messages: { en, fr },
});

/** Persist the user's chosen locale and update the i18n instance. */
export function setLocale(locale: SupportedLocale) {
    (i18n.global.locale as { value: SupportedLocale }).value = locale;
    localStorage.setItem(LOCALE_KEY, locale);
    document.documentElement.lang = locale;
}

export { SUPPORTED_LOCALES };
export type { SupportedLocale };
