<?php
// データベース接続情報
require_once '../db.php';

header('Content-Type: application/json');

// POSTリクエストのデータを取得
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // JSON データを取得
    $json = file_get_contents('php://input');
    $posts = json_decode($json, true);
    $conversations = $posts['conversations'];

    try {
        foreach ($conversations as $conversation) {
            // 既存のIDをチェック
            $checkSql = "SELECT COUNT(*) FROM translation_history WHERE id = :id";
            $checkStmt = $pdo->prepare($checkSql);
            $checkStmt->execute(['id' => $conversation['id']]);
            $exists = $checkStmt->fetchColumn();

            if ($exists > 0) {
                // IDが存在する場合、スキップ
                continue;
            }

            // データベースに挿入
            $sql = "INSERT INTO translation_history (id, from_lang, to_lang, text, translated_text) 
                    VALUES (:id, :from_lang, :to_lang, :text, :translated_text)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'id' => $conversation['id'],
                'from_lang' => $conversation['from_lang'],
                'to_lang' => $conversation['to_lang'],
                'text' => $conversation['text'],
                'translated_text' => $conversation['translated_text'],
            ]);
        }
        echo json_encode(['success' => true, 'message' => '会話が保存されました。']);
    } catch (PDOException $e) {
        echo json_encode(['error' => false, 'message' => '保存中にエラーが発生しました: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => false, 'message' => '無効なリクエストです。']);
}