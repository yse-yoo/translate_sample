<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>音声会話翻訳アプリ</title>
    <!-- Tailwind CSSのリンクを追加 -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .chat-bubble {
            max-width: 45%;
            padding: 10px;
            border-radius: 20px;
            margin-bottom: 10px;
            position: relative;
            display: inline-block;
        }

        .left-bubble {
            background-color: #f0f0f0;
            align-self: flex-start;
            text-align: left;
        }

        .right-bubble {
            background-color: #e0f7fa;
            align-self: flex-end;
            text-align: right;
        }

        .chat-container {
            display: flex;
            flex-direction: column;
        }

        .left-align {
            display: flex;
            justify-content: flex-start;
            align-items: center;
        }

        .right-align {
            display: flex;
            justify-content: flex-end;
            align-items: center;
        }

        .audio-icon {
            width: 30px;
            height: 30px;
            margin-left: 10px;
            cursor: pointer;
        }
    </style>
</head>

<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white shadow-lg rounded-lg p-8 max-w-md w-full">
        <h1 class="text-2xl font-bold text-center text-blue-500 mb-6">音声会話翻訳アプリ</h1>

        <!-- 言語選択ボックス -->
        <div class="flex justify-between mb-4">
            <div class="w-1/2 pr-2">
                <label for="inputLang" class="block text-gray-700 font-bold mb-2">入力言語</label>
                <select id="inputLang" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                    <option value="ja">日本語</option>
                    <option value="en">英語</option>
                    <option value="zh-CN">中国語（簡体字）</option>
                    <option value="ko">韓国語</option>
                </select>
            </div>
            <div class="w-1/2 pl-2">
                <label for="outputLang" class="block text-gray-700 font-bold mb-2">翻訳先言語</label>
                <select id="outputLang" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                    <option value="en">英語</option>
                    <option value="ja">日本語</option>
                    <option value="zh-CN">中国語（簡体字）</option>
                    <option value="ko">韓国語</option>
                </select>
            </div>
        </div>

        <!-- 入力テキストボックス -->
        <div class="w-full px-3 py-2 border border-gray-300 rounded-lg mb-4">
            <input id="inputText" class="text-gray-600" value="こんにちわ">
        </div>
        <button class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 mb-4" onclick="startRecognition()">
            テキスト翻訳
        </button>
        <!-- 音声入力ボタン -->
        <button class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 mb-4" onclick="startRecognition()">
            音声入力開始
        </button>


        <!-- 会話履歴 -->

        <div class="w-full px-3 py-2 border border-gray-300 rounded-lg mb-4">
            <h2 class="text-lg font-bold text-gray-700">会話履歴</h2>
            <div>
                <!-- 会話保存 -->
                <button class="px-2 bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 mb-4" onclick="saveConversation()">
                    会話保存
                </button>
            </div>

            <!-- 会話履歴へのリンクを追加 -->
            <a href="history.php" class="text-blue-500 hover:underline block mb-4">すべての会話履歴を表示</a>

            <!-- チャット形式の会話履歴 -->
            <div id="chatHistory" class="chat-container"></div>
        </div>
    </div>

    <script>
        // ダミーデータで会話履歴を表示する例（実際には音声ファイルのURLを動的に設定）
        const history = [{
                input: "こんにちは",
                output: "Hello",
                inputAudioUrl: "audio/input1.mp3",
                outputAudioUrl: "audio/output1.mp3"
            },
            {
                input: "お元気ですか？",
                output: "How are you?",
                inputAudioUrl: "audio/input2.mp3",
                outputAudioUrl: "audio/output2.mp3"
            },
            {
                input: "ありがとう",
                output: "Thank you",
                inputAudioUrl: "audio/input3.mp3",
                outputAudioUrl: "audio/output3.mp3"
            }
        ];

        const chatHistoryContainer = document.getElementById('chatHistory');

        // チャット履歴を生成して表示
        history.forEach((entry, index) => {
            // 左側に入力テキストを表示
            const leftBubble = document.createElement('div');
            leftBubble.classList.add('chat-bubble', 'left-bubble');
            leftBubble.innerText = entry.input;

            // 音声アイコンを左バブルに追加
            const inputAudioIcon = document.createElement('img');
            inputAudioIcon.src = "images/audio-icon.png"; // 音声再生アイコンのURL
            inputAudioIcon.classList.add('audio-icon');
            inputAudioIcon.onclick = function() {
                const audio = new Audio(entry.inputAudioUrl);
                audio.play();
            };

            const leftAlign = document.createElement('div');
            leftAlign.classList.add('left-align');
            leftAlign.appendChild(leftBubble);
            leftAlign.appendChild(inputAudioIcon); // アイコンを左側のバブルの隣に配置

            // 右側に翻訳されたテキストを表示
            const rightBubble = document.createElement('div');
            rightBubble.classList.add('chat-bubble', 'right-bubble');
            rightBubble.innerText = entry.output;

            // 音声アイコンを右バブルに追加
            const outputAudioIcon = document.createElement('img');
            outputAudioIcon.src = "images/audio-icon.png"; // 音声再生アイコンのURL
            outputAudioIcon.classList.add('audio-icon');
            outputAudioIcon.onclick = function() {
                const audio = new Audio(entry.outputAudioUrl);
                audio.play();
            };

            const rightAlign = document.createElement('div');
            rightAlign.classList.add('right-align');
            rightAlign.appendChild(rightBubble);
            rightAlign.appendChild(outputAudioIcon); // アイコンを右側のバブルの隣に配置

            // 両方のチャットバブルを追加
            chatHistoryContainer.appendChild(leftAlign);
            chatHistoryContainer.appendChild(rightAlign);
        });

        // 保存機能はダミーの状態
        function saveConversation() {
            alert("会話が保存されました!");
        }
    </script>
</body>

</html>