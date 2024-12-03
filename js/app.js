const fromLangSelect = document.getElementById('inputLang');
const toLangSelect = document.getElementById('outputLang');
var conversations = [];

const timestamp = new Date().toISOString();

// Web Speech APIを使用した音声認識
function startRecognition() {
    if (!('webkitSpeechRecognition' in window)) {
        alert("お使いのブラウザは音声認識をサポートしていません。");
        return;
    }

    const recognition = new webkitSpeechRecognition();
    recognition.lang = fromLangSelect.value;
    recognition.interimResults = false;
    recognition.continuous = false;

    recognition.onresult = function (event) {
        const text = event.results[0][0].transcript;
        document.getElementById('inputText').value = text;
        const fromLang = fromLangSelect.value;
        const toLang = toLangSelect.value;
        translate(text, fromLang, toLang);
    };

    recognition.onerror = function (event) {
        alert("音声認識に失敗しました: " + event.error);
    };

    recognition.start();
}

// テキスト翻訳
const onTranslate = async () => {
    const text = document.getElementById('inputText').value;
    const fromLang = fromLangSelect.value;
    const toLang = toLangSelect.value;
    const translatedText = await translate(text, fromLang, toLang);

    if (translatedText) {
        const translationHistory = document.getElementById('translationHistory');
        const uuid = crypto.randomUUID(); // UUID を生成

        // 会話データの一時保存
        conversations.push({
            id: uuid, // UUID を追加
            from_lang: fromLang,
            text: text,
            to_lang: toLang,
            translated_text: translatedText,
        });

        // 自分の発言
        const userItem = document.createElement('li');
        userItem.dataset.lang = fromLang;
        userItem.innerHTML = text;
        translationHistory.appendChild(userItem);

        // 翻訳された発言
        const translatedItem = document.createElement('li');
        translatedItem.dataset.lang = toLang;
        translatedItem.innerHTML = translatedText;
        translationHistory.appendChild(translatedItem);
    }
};


// 翻訳機能
const translate = async (text, fromLang, toLang) => {
    console.log(text, fromLang, toLang);
    try {
        const response = await fetch(TRANSLATION_URI, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                origin: text,
                fromLang: fromLang,
                toLang: toLang
            })
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();
        const translatedText = data.translate ? data.translate : "Translation error.";
        document.getElementById('outputText').innerHTML = translatedText;

        // 翻訳結果を読み上げる
        speakText(translatedText, toLangSelect.value);

        return translatedText;
    } catch (error) {
        console.error('Fetch error:', error);
        alert("翻訳に失敗しました。エラー内容：" + error.message);
        return null;
    }
};

// テキストを読み上げる機能
const speakText = (text, lang) => {
    console.log("speak", text, lang)
    const synth = window.speechSynthesis;
    const utterance = new SpeechSynthesisUtterance(text);
    utterance.lang = lang; // 翻訳先の言語で読み上げ
    synth.speak(utterance);
};

// 再生ボタンのクリックで読み上げる機能
const playTranslation = () => {
    const translatedText = document.getElementById('outputText').textContent;
    const toLang = toLangSelect.value;
    speakText(translatedText, toLang);
}

function saveConversation() {
    if (conversations.length === 0) {
        alert('保存する会話がありません。');
        return;
    }
    console.log(conversations);
    console.log(SAVE_CONVERSATIONS_URI)

    // サーバーに送信
    fetch(SAVE_CONVERSATIONS_URI, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ conversations: conversations })
    })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            if (data.success) {
                alert('会話を保存しました。');
            } else {
                alert('会話の保存に失敗しました。');
            }
        })
        .catch(error => {
            console.error('エラー:', error);
            alert('保存中にエラーが発生しました。');
        });
}

function testConversationList() {
    conversations = [
        {
            id: "550e8400-e29b-41d4-a716-446655440000",
            from_lang: "ja-JP",
            text: "こんにちは",
            to_lang: "en-US",
            translated_text: "Hello"
        },
        {
            id: "550e8400-e29b-41d4-a716-446655440001",
            from_lang: "ja-JP",
            text: "さようなら",
            to_lang: "en-US",
            translated_text: "Goodbye"
        },
    ];

    const translationHistory = document.getElementById('translationHistory');
    conversations.forEach((conversation) => {
        // 自分の発言
        const userItem = document.createElement('li');
        userItem.dataset.lang = conversation.fromLang;
        userItem.innerHTML = conversation.text;
        translationHistory.appendChild(userItem);

        // 翻訳された発言
        const translatedItem = document.createElement('li');
        translatedItem.dataset.lang = conversation.toLang;
        translatedItem.innerHTML = conversation.translated_text;
        translationHistory.appendChild(translatedItem);
    })

}