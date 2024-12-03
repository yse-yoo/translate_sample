CREATE TABLE translation_history (
    id VARCHAR(36) PRIMARY KEY, -- UUID を格納するための VARCHAR(36)
    from_lang VARCHAR(10) NOT NULL, -- 入力言語コード
    to_lang VARCHAR(10) NOT NULL, -- 翻訳言語コード
    text TEXT NOT NULL, -- 入力テキスト
    translated_text TEXT NOT NULL, -- 翻訳されたテキスト
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP -- 作成日時
);