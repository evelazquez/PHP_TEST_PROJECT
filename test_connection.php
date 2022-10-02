<?php

try {
    $db = new PDO('pgsql:host=localhost;dbname=test_project;');

    if(isset($_POST["search"]) && $_POST["search"]!=""){
        $where = "where authors.name like '%".$_POST['search']."%'";
    }else{
        $where= "";
    }
    $sql = "select authors.name as author, books.name as book from authors left join books on books.author_id = authors.author_id ".$where." order by authors.author_id;";
    $data = $db->prepare($sql);
    $data->execute();
    $books = $data->fetchAll();

}catch(Exception $e){
    echo "<pre>".$e."</pre>";
}catch(\PDOException $E){
    echo "<pre>".$e."</pre>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Test PHP</title>
    <meta charset=utf-8>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="script.js"></script>
</head>
<body>
    <div class="container">
        <h1 class="title">PHP TEST PROJECT</h1>
        <p>This test project shows a library of books by author, developed with PHP, JavaScript, HTML5, CSS3 and PostgreSQL technologies. This books were imported from an XML file.</p>
        <p>In order to import books from an XML file, you need to run the xml_reader.php script and it will be stored on our local PostgreSQL DB.</p>
        <p>You can search for an author in the next input, and you will see their books.</p>
        <div class="search">
            <form method="POST">
                <input type="text" id="search" name="search" value="<?php echo $_POST["search"]?>">
                <input type="submit" value="Search">
                <input type="submit" value="Reset" onclick="clearForm()">
            </form>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Author</th>
                    <th>Book</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($books as $book) {
                ?>
                <tr>
                    <td><?php echo $book['author']?></td>
                    <td><?php echo $book['book'] != "" ? $book['book'] : htmlspecialchars("<none> (no books found)") ?></td>
                </tr>
                
                <?php }?>
            </tbody>
        </table>
    </div>
</body>
