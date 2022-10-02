<?php 

$db = new PDO('pgsql:host=localhost;dbname=test_project;');

$xml = simplexml_load_file('books.xml');

foreach ($xml as $book) {
    try{
        $insert = $db->prepare("INSERT INTO authors(name) SELECT :name::text where not exists(select name from authors where name = :name::text) ;");
        $insert->bindValue(':name', $book->author, PDO::PARAM_STR);
        $insert->execute();
        $id =  $db->lastInsertId();
        if($id == 0){
            $author = $db->prepare("select author_id from authors where name like :name::text;");
            $author->bindValue(':name', $book->author, PDO::PARAM_STR);
            $author->execute();
            $id = $author->fetch()["author_id"];
        }

        $insert_book = $db->prepare("INSERT INTO books(name, author_id) SELECT :name::text, :author_id where not exists(select name from books where name = :name::text and author_id = :author_id) ;");
        $insert_book->bindValue(':name', $book->name, PDO::PARAM_STR);
        $insert_book->bindValue(':author_id', $id, PDO::PARAM_INT);
        $insert_book->execute();

    }catch(Exception $e){
        echo "<pre>".$e."</pre>";
    }catch(\PDOException $E){
        echo "<pre>".$e."</pre>";
    }
}

?>