<?php
function GenerateHtml($comments) {
    $commentMap = array();
    $html = '<ul>';

    foreach ($comments as $comment) {
        $commentMap[$comment[0]] = array(
            'id' => $comment[0],
            'parentId' => $comment[1],
            'text' => $comment[2],
            'children' => array()
        );
    }

    foreach ($commentMap as $comment) {
        $parentId = $comment['parentId'];
        if ($parentId != $comment['id'] && isset($commentMap[$parentId])) {
            $commentMap[$parentId]['children'][] = &$commentMap[$comment['id']];
        }
    }

    foreach ($commentMap as $comment) {
        if ($comment['parentId'] == $comment['id']) {
            $html .= '<li>' . $comment['text'];
            if (!empty($comment['children'])) {
                $html .= generateChildrenHtml($comment['children']);
            }
            $html .= '</li>';
        }
    }

    $html .= '</ul>';
    return $html;
}

function generateChildrenHtml($children) {
    $html = '<ul>';
    foreach ($children as $child) {
        $html .= '<li>' . $child['text'];
        if (!empty($child['children'])) {
            $html .= generateChildrenHtml($child['children']);
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

$html = GenerateHtml($comments);
echo $html;
?>