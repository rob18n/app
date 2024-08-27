import { createI18n } from "vue-i18n";

const modules = import.meta.glob('@/lang/*.json', { eager: true });
const messages = {};

for (const path in modules) {
    const locale = path.match(/\/lang\/(.*)\.json$/)[1];
    messages[locale] = modules[path].default || modules[path];
}

const i18n = createI18n({
    legacy: false,
    locale: 'en_US',
    fallbackLocale: 'en_US',
    messages: messages
});

export default i18n;
