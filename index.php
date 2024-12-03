<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>音声会話翻訳アプリ</title>
    <!-- Tailwind CSSのリンクを追加 -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white shadow-lg rounded-lg p-8 max-w-md w-full">
        <h1 class="text-2xl font-bold text-center text-blue-500 mb-6">音声会話翻訳アプリ</h1>

        <!-- 言語選択ボックス -->
        <div class="flex justify-between mb-4">
            <div class="w-1/2 pr-2">
                <label for="inputLang" class="block text-gray-700 font-bold mb-2">入力言語</label>
                <select id="inputLang" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                    <option value="ja-JP">日本語</option>
                    <option value="en-US">英語</option>
                    <option value="zh-CN">中国語（簡体字）</option>
                    <option value="ko">韓国語</option>
                    <option value="vi">ベトナム語</option>
                </select>
            </div>
            <div class="w-1/2 pl-2">
                <label for="outputLang" class="block text-gray-700 font-bold mb-2">翻訳先言語</label>
                <select id="outputLang" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                    <option value="en-US">英語</option>
                    <option value="ja-JP">日本語</option>
                    <option value="zh-CN">中国語（簡体字）</option>
                    <option value="ko">韓国語</option>
                    <option value="vi">ベトナム語</option>
                </select>
            </div>
        </div>

        <!-- 音声入力ボタン -->
        <button class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 mb-4" onclick="startRecognition()">
            音声入力開始
        </button>

        <!-- 入力テキストボックス -->
        <div class="w-full px-3 py-2 border border-gray-300 rounded-lg mb-4">
            <input id="inputText" type="text" class="w-full text-gray-600">
        </div>

        <!-- テキスト翻訳ボタン -->
        <button onclick="onTranslate()" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 mb-4">
            テキスト翻訳
        </button>

        <!-- 翻訳結果ボックス -->
        <!-- 翻訳結果ボックス -->
        <div class="w-full px-3 py-2 border border-gray-300 rounded-lg mb-4">
            <p id="outputText" class="text-gray-600">翻訳結果がここに表示されます</p>
            <button id="playTranslation" class="w-full bg-green-500 text-white py-2 rounded-lg hover:bg-green-600 mt-2" onclick="playTranslation()">
                翻訳結果を再生
            </button>
        </div>


        <!-- 翻訳結果の会話形式表示 -->
        <h2 class="text-lg font-bold text-gray-700">会話一覧</h2>
        <div id="translationList" class="w-full px-3 py-2 border border-gray-300 rounded-lg mb-4" style="height: 200px; overflow-y: auto;">
            <ul id="translationHistory" class="space-y-1 text-gray-600"></ul>
        </div>

        <!-- 会話保存ボタン -->
        <button class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 mb-4" onclick="saveConversation()">
            会話保存
        </button>

        <!-- 会話履歴 -->
        <div class="w-full px-3 py-2 border border-gray-300 rounded-lg mb-4">
            <h2 class="text-lg font-bold text-gray-700">会話履歴</h2>
            <a href="history.php" class="text-blue-500 hover:underline block mb-4" target="_blank">すべての会話履歴を表示</a>
            <ul id="history" class="list-disc pl-5 text-gray-600"></ul>
        </div>
    </div>

    <button onclick="testConversationList()">テスト履歴</button>
    <script src="js/config.js"></script>
    <script src="js/app.js"></script>
</body>

</html>