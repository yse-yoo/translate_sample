// 現在のホスト名を動的に取得して TRANSLATION_URI を設定
const host = location.origin;
const TRANSLATION_URI = `${host}/translate_sample/api/ai_translate.php`;
const SAVE_CONVERSATIONS_URI = `${host}/translate_sample/api/save_conversations.php`;