<?php
    $host='localhost';
    $db = 'task_bd';
    $username = 'postgres';
    $password = 'qwerty';

    $dbconn = pg_connect("host=$host port=5432 dbname=$db user=$username password=$password");

    if (!$dbconn) {
        die('Could not connect');
    }
    else {
        echo ("Connected to local DB");
    }

    $sql = "
        DROP TABLE IF EXISTS EMPLOYEES;
        CREATE TABLE EMPLOYEES (
            EmployeeId INT PRIMARY KEY,
            ChiefId INT,
            Department VARCHAR(50),
            Name VARCHAR(50),
            Salary VARCHAR(10)
        );
    ";

    $res = pg_query($sql);

    $employees = array(
        1 => [1, 1, "Sales", "Айгерим", "$800"],
        2 => [2, 1, "Sales", "Диляра", "$700"],
        3 => [3, 4 ,"Marketing", "Мариям", "$900"],
        4 => [4, 4 ,"Marketing", "Сабина", "$900"],
        5 => [5, 4 ,"Marketing", "Мадина", "$1000"],
        6 => [6, 8 ,"QA", "Торгын", "$300"],
        7 => [7, 8 ,"QA", "Айжан", "$200"],
        8 => [8, 8 ,"QA", "Дидар", "$200"],
    );
//
//$result = pg_query("INSERT INTO EMPLOYEES (EmployeeId, ChiefId, Department, Name ,Salary) VALUES(1, 2, 'hello', 'sales' , '456'");

foreach($employees as $id => $arr)
    {
        $result = pg_query('INSERT INTO EMPLOYEES (EmployeeId, ChiefId, Department, Name ,Salary) VALUES (' . $id . ', ' . $arr[1] . ', \'' . $arr[2] . '\', \'' . $arr[3] . '\', \'' . $arr[4] . '\')') or die('Query failed: ' . pg_last_error());
    }

    $query = 'SELECT * FROM EMPLOYEES';
    $result = pg_query($query) or die('Query failed: ' . pg_last_error());

    echo "<table>\n";
    while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
        echo "\t<tr>\n";
        foreach ($line as $col_value) {
            echo "\t\t<td>$col_value</td>\n";
        }
        echo "\t</tr>\n";
    }
    echo "</table>\n";

    $query2 = 'SELECT e.EmployeeId, e.Name, e.Salary, c.Name AS ChiefName, c.Salary AS ChiefSalary
                    FROM EMPLOYEES e
                    JOIN EMPLOYEES c ON e.ChiefId = c.EmployeeId
                    WHERE e.Salary > c.Salary;
    ';

    $selectRes = pg_query($dbconn, $query2);

    echo "\t\t<h2>task2</h2>\n";

    echo "<table>\n";
    while ($line = pg_fetch_array($selectRes, null, PGSQL_ASSOC)) {
        echo "\t<tr>\n";
        foreach ($line as $col_value) {
            echo "\t\t<td>$col_value</td>\n";
        }
        echo "\t</tr>\n";
    }
    echo "</table>\n";

    $query3 = 'SELECT Department, COUNT(*) AS EmployeeCount
                    FROM EMPLOYEES
                    GROUP BY Department
                    HAVING COUNT(*) <= 3
    ';

    $selectRes2 = pg_query($dbconn, $query3);

    echo "\t\t<h2>task3</h2>\n";

    echo "<table>\n";
    while ($line = pg_fetch_array($selectRes2, null, PGSQL_ASSOC)) {
        echo "\t<tr>\n";
        foreach ($line as $col_value) {
            echo "\t\t<td>$col_value</td>\n";
        }
        echo "\t</tr>\n";
    }
    echo "</table>\n";

    pg_free_result($result);

    pg_close($dbconn);

    ?>