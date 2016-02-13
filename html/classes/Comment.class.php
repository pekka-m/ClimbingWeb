<?php

class Comment {
    
    function __construct() {
    }
    
    /**
     * Haetaan kohteen kaikki kommentit tietokannasta.
     * @param  integer $_id             Haettavan kohteen id (route, crag) tai email (user).
     * @param  string  [$_where='user'] Mistä taulusta haetaan (route, crag, user). Oletuksena user.
     * @return array   Kohteen kommentit.
     */
    public function getComments($_id, $_where='user') {
        require('/var/www/db-init-climb.php');
        switch($_where){
            case'user':  {
                $stmt = $db->prepare(
                    "SELECT * FROM Comment
                    INNER JOIN UserCommentTarget
                    ON Comment.CommentId=UserCommentTarget.CommentId
                    WHERE UserCommentTarget.UserId=(
                        SELECT UserId
                        FROM User
                        WHERE Email=:email
                    )
                    ORDER BY Comment.DateTime DESC"
                );
                $stmt->execute([
                    ':email' => $_id
                ]);
                break;
            }
            case'route': {
                $stmt = $db->prepare(
                    "SELECT * FROM Comment
                    INNER JOIN RouteCommentTarget
                    ON Comment.CommentId=RouteCommentTarget.CommentId
                    WHERE RouteCommentTarget.RouteId=:routeid
                    ORDER BY Comment.DateTime DESC"
                );
                $stmt->execute([
                    ':routeid' => $_id
                ]);
                break;
            }
            case'crag':{
                $stmt = $db->prepare(
                    "SELECT * FROM Comment
                    INNER JOIN CragCommentTarget
                    ON Comment.CommentId=CragCommentTarget.CommentId
                    WHERE CragCommentTarget.CragId=:cragid
                    ORDER BY Comment.DateTime DESC"
                );
                $stmt->execute([
                    ':cragid' => $_id
                ]);
                break;
            }           
        }
        unset($db);
        return $stmt;
    }
    
    /**
     * Haetaan kommentoijan email id:n perusteella.
     * @param  integer $_id Kommentoijan id.
     * @return string  Kommentoijan email.
     */
    public function getCommenter($_id) {
        require('/var/www/db-init-climb.php');
        $stmt = $db->prepare(
            "SELECT Email
            FROM User
            WHERE UserId=:id"
        );
        $stmt->execute([
            ':id' => $_id
        ]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['Email'];
    }
    
    /**
     * Tulostaa kommentointilomakkeen.
     * @param  integer $_target                Id (route, crag) tai email (user), johon kommentti kohdistetaan.
     * @param  string  [$_commenttable='user'] Mitä kommentoidaan (route, crag tai user). Oletuksena user.
     * @return string  Kommenttilomake.
     */
    public function printCommentBox($_target, $_commenttable='user') {
        return "<p><form action='addcomment.php' method='POST'>" .
            "<textarea name='comment'></textarea><br>" .
            "<input type='submit' value='Lisää kommentti'>" .
            "<input type='hidden' id='commenttable' name='commenttable' value='{$_commenttable}'>" .
            "<input type='hidden' id='targetti' name='target' value='{$_target}'>" .
            "</form></p>";
    }
    
    /**
     * Lisätään kommentti Comment-tauluun.
     * Otetaan lisätyn kommentin Id talteen.
     * Liitetään kommentti oikeaan kohteeseen yhdellä kolmesta liitostauluista.
     * @param integer $_commenter    Kommentoijan Id.
     * @param integer $_target       Id (route, crag) tai email (user), johon kommentti kohdistetaan.
     * @param string  $_comment      Kommentti.
     * @param string  $_commenttable Mitä kommentoidaan (route, crag tai user).
     */
    public function addComment($_commenter, $_target, $_comment, $_commenttable) {
        require('/var/www/db-init-climb.php');
        $stmt = $db->prepare(
            "INSERT INTO Comment (CommenterId, Comment, DateTime)
            VALUES (:commenter, :comment, :datetime)"
        );
        $stmt->execute([
            ':commenter' => $_commenter,
            ':comment' => $_comment,
            ':datetime' => date("Y-m-d H:i:s")
        ]);
        $lastid = $db->lastInsertId();
        switch($_commenttable) {
            case "user": {
                //haetaan annetun emailin ($_target) perusteella userid
                $stmt = $db->prepare(
                    "SELECT UserId
                    FROM User WHERE
                    Email=:email"
                );
                $stmt->execute([
                    ':email' => $_target
                ]);
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $userid = $row['UserId'];
                $stmt = $db->prepare(
                    "INSERT INTO UserCommentTarget (CommentId, UserId)
                    VALUES (:commentid, :userid)"
                );
                $stmt->execute([
                    ':commentid' => $lastid,
                    ':userid' => $userid
                ]);
                break;
            }
            case "crag": {
                $stmt = $db->prepare(
                    "INSERT INTO CragCommentTarget (CommentId, CragId)
                    VALUES (:commentid, :cragid)"
                );
                $stmt->execute([
                    ':commentid' => $lastid,
                    ':cragid' => $_target
                ]);
                break;
            }
            case "route": {
                $stmt = $db->prepare(
                    "INSERT INTO RouteCommentTarget (CommentId, RouteId)
                    VALUES (:commentid, :routeid)"
                );
                $stmt->execute([
                    ':commentid' => $lastid,
                    ':routeid' => $_target
                ]);
                break;
            }
        }
        unset($db);
    }
}
?>