<?php
$dbUserName = 'root';
$dbPassword = 'password';
$pdo = new PDO(
    'mysql:host=mysql; dbname=memo; charset=utf8',
    $dbUserName,
    $dbPassword
);

if (isset($_GET['keyword'])) {
    $keyword = $_GET['keyword'];

    $sql = "SELECT * FROM pages WHERE title LIKE :keyword OR content LIKE :keyword";
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':keyword', '%' . $keyword . '%', PDO::PARAM_STR);
    $statement->execute();
    $pages = $statement->fetchAll(PDO::FETCH_ASSOC);
} else {
    $sql = 'SELECT * FROM pages';
    $statement = $pdo->prepare($sql);
    $statement->execute();
    $pages = $statement->fetchAll(PDO::FETCH_ASSOC);
}
?>

<body>
  <div>
    <form method="GET" action="">
      <input type="text" name="keyword" placeholder="検索キーワードを入力してください">
      <button type="submit">検索</button>
    </form>
    <a href="./create.php">メモを追加</a><br>
  </div>

  <div>
    <table border="1">
      <tr>
        <th>タイトル</th>
        <th>内容</th>
        <th>作成日時</th>
        <th>編集</th>
        <th>削除</th>
      </tr>

      <?php foreach ($pages as $page): ?>
        <tr>
          <td><?php echo $page['title']; ?></td>
          <td><?php echo $page['content']; ?></td>
          <td><?php echo $page['created_at']; ?></td>
          <td><a href="./edit.php?id=<?php echo $page['id']; ?>">編集</a></td>
          <td><a href="./delete.php?id=<?php echo $page['id']; ?>">削除</a></td>
        </tr>
      <?php endforeach; ?>

    </table>
  </div>
</body>
