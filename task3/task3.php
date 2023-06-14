<?php
function buildCommentTree($comments) {
    $commentMap = array();

    foreach ($comments as $comment) {
    $commentMap[$comment[0]] = $comment;
    }

    foreach ($commentMap as $comment) {
        $parentId = $comment[1];
        if ($parentId != $comment[0]) {
            if (isset($commentMap[$parentId])) {
                $parentComment = $commentMap[$parentId];
                    if (!isset($parentComment[3])) {
                        $parentComment[3] = array();
                    }
                $parentComment[3][] = $comment;
                $commentMap[$parentId] = $parentComment;
            }
        }
        }

    $html = GenerateHtml($commentMap);
    return $html;
}

function GenerateHtml($comments) {
$html = '<ul>';
    foreach ($comments as $comment) {
    $id = $comment[0];
    $parentId = $comment[1];
    $text = $comment[2];
    $childComments = isset($comment[3]) ? $comment[3] : array();

    $html .= '<li>' . $text;
        if (!empty($childComments)) {
        $html .= GenerateHtml($childComments);
        }
        $html .= '</li>';
    }
    $html .= '</ul>';

    return $html;
}

$comments = array(
    array(1, 1, "Comment 1"),
    array(2, 1, "Comment 2"),
    array(3, 2, "Comment 3"),
    array(4, 1, "Comment 4"),
    array(5, 2, "Comment 5"),
    array(6, 3, "Comment 6"),
    array(7, 7, "Comment 7")
);

$html = buildCommentTree($comments);
echo $html;
?>
