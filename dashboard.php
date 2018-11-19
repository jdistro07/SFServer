<?php 

//initialize modules on start
require 'php/auth-mods/auth-login.php';
$userid = $_SESSION["user_ID"];

?>

<html>
    <header>
        <title>Dashboard</title>
        <link href="css/bootstrap.css" rel="stylesheet" type="text/css"/>
        <link href="css/global-style.css" rel="stylesheet" type="text/css"/>
        <link href="css/class-search.css" rel="stylesheet" type="text/css"/>

        <script src = "js/jquery.js"></script>
    </header>

    <body>

        <div><?php include 'widgets/navigation.php';?></div>

        <div><?php include 'widgets/logged_user.php';?></div>

        <!-- Main contnainer -->
        <div style = "height: 840px; margin: 0 auto;" class="col-lg-6 col-lg-offset-3" id="container">

            <center><h1>Dashboard</h1></center>

            <div>
                <div>
                    <h4 style = "margin: 2px 2px 2px 2px;">Student List</h4>
                    <hr style = "margin: 2px 2px 5px 2px;"/>
                </div>
                
                <!--Grade combobox-->
                <span class="badge badge-secondary">Class Filter</span>
                <select id = "grade-filter" style="width: 100%">
                    <?php
                        $fetchLevels = mysqli_query($conn,
                            "SELECT class_ID, class_grade, class_section
                            FROM class
                            WHERE class_staff = $userid"
                        );

                        while ($gradeLevels = mysqli_fetch_assoc($fetchLevels))
                        {
                            echo '<option value="'.$gradeLevels['class_ID'].'">';
                            echo "Grade " . $gradeLevels['class_grade'] . " - " . $gradeLevels['class_section'];
                            echo "</option>";
                        }
                    ?>
                </select>
            <div>
            <div style = "overflow-y: auto; max-height: 200px; border-color: black; border-width: 3px;">
                <!--Table-->
                <table class="table table-sm table-hover">
                    <thead>
                        <tr>
                        <th scope="col">Name</th>
                        <th scope="col" class = "text-center">Grade & Section</th>
                        </tr>
                    </thead>

                    <tbody id = "student_data-table"><!--Display student data here--></tbody>
                </table>
            </div>

            <!--Test list table-->
            <div>
                <h4 style = "margin: 2px 2px 2px 2px;">Test list</h4>
                <hr style = "margin: 2px 2px 5px 2px;"/>
            </div>
            <form id = "test_form" action = "../php/mod_deleteTest.php" method = "POST">
                <input onclick = "return confirm('Confirm deleting marked tests?')" class = "btn btn-danger" type = "submit" value = "Delete" name = "btn-testDelete">

                <div style = "overflow-y: auto; max-height: 400px; border-color: black; border-width: 3px;">
                    <table class="table table-hover table-sm">
                        <thead>
                            <tr>
                            <th scope="col"></th>
                            <th scope="col" class = "text-center">Test Name</th>
                            <th scope="col" class = "text-center">Author</th>
                            <th scope="col" class = "text-center">Type</th>
                            <th scope="col" class = "text-center">Availability</th>
                            </tr>
                        </thead>
                            
                        <tbody>
                            <!--Loop tests published by the current logged user-->
                            <?php
                            $q_ownedTests = mysqli_query($conn, 
                            "SELECT 
                            tests.*,
                            CONCAT(
                                staffs.staff_lname,
                                ', ',
                                staffs.staff_fname,
                                ' ',
                                staffs.staff_mname
                            ) AS authorName
                            
                            FROM tests LEFT JOIN staffs ON tests.test_staffAuthor = staffs.staff_ID
                            
                            WHERE 
                            tests.test_staffAuthor = $userid ORDER BY tests.test_name ASC
                            ") or die(mysqli_error($conn));

                            while($r_ownedTests = mysqli_fetch_assoc($q_ownedTests)){
                                echo '<tr>';
                                echo '<th scope="row"><input id = "idMark" type = "checkbox" name = "testsMark[]" value = '.$r_ownedTests['test_ID'].'></th>';
                                echo '<td style = "width: 300px;"><a style = "text-decoration: none;" href = "maketest.php?request=update&testID='.$r_ownedTests['test_ID'].'&owner='.$userid.'">'.$r_ownedTests['test_name'].'</a></td>';
                                echo '<td>'.$r_ownedTests['authorName'].'</td>';
                                echo '<td>'.$r_ownedTests['test_type'].'</td>';

                                // show combobox only for custom tests
                                if($r_ownedTests['test_type'] == "Custom"){
                                    echo '
                                    <td align = "center">
                                    <select id = "state">';

                                    switch($r_ownedTests['test_visibility']){
                                        case 0:
                                        echo '<option value = "'.$r_ownedTests['test_ID'].':private" selected>Private/Hidden</option>
                                        <option value = "'.$r_ownedTests['test_ID'].':broadcast">Show</option>';

                                        break;

                                        case 1:
                                        echo '<option value = "'.$r_ownedTests['test_ID'].':private">Private/Hidden</option>
                                        <option value = "'.$r_ownedTests['test_ID'].':broadcast" selected>Show</option>';

                                        break;
                                    }

                                    echo 
                                    '</select>
                                    </td>';
                                }else{
                                    echo '<td align = "center"><i>In-game</i></td>';
                                }
                                echo '</tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    </body>

    <script>
        $(document).ready(function(){

            var gradeFilter_load = $('#grade-filter').val();

            $.get('php/mod_student-filter.php',{filter:gradeFilter_load}, function(response){
                $('#student_data-table').html(response);
            });

            $('#test_form > div > table > tbody > tr > td > #state').each(function(index){
                $(this).on('change', function(){

                    var stateValue = $(this).val();

                    // get the id from the current test item
                    $.get('php/minimod_testState.php',{state:stateValue}, function(response){
                        alert(response);
                    });

                });
            });

            $('#grade-filter').on('change',function(){
                var grade = $(this).val();

                $.get('php/mod_student-filter.php',{filter:grade}, function(response){
                    $('#student_data-table').html(response);
                });
            });
        });
    </script>
</html>