<?php 
require 'php/mod_conn.php';

session_start();
//value references
$user_id = $_GET['id'];
$user_username = $_GET['user'];

//values to display
$name; $lname;
$id;
$class;
$account_level;
$rating;

// user update references
$requestType;

$q_find_staff = mysqli_query($conn, 

"SELECT 
staffs.*,

IFNULL(
    
	ROUND(AVG(performance_data.pf_rating),2),
   	'Unrated'
   

) AS rating

FROM staffs LEFT JOIN performance_data ON 
staffs.staff_ID = performance_data.pf_userID AND staffs.staff_username = performance_data.pf_username

WHERE 
staffs.staff_ID = $user_id AND 
staffs.staff_username = '".$user_username."'

") or die(mysqli_error($conn));

if($_GET['userType'] == "staff"){

    //set staff credential values
    $r_q_find_staff = mysqli_fetch_assoc($q_find_staff);

    $name = $r_q_find_staff['staff_lname'].", ".$r_q_find_staff['staff_fname']." ".$r_q_find_staff['staff_mname'];
    $lname = $r_q_find_staff['staff_lname'];
    $id = $r_q_find_staff['staff_ID'];
    $account_level = $r_q_find_staff['staff_accountLevel'];
    $rating = $r_q_find_staff['rating'];

    //set request type
    $requestType = "staffupdate";

}else if ($_GET['userType'] == "student"){

    $q_find_student = mysqli_query($conn, 

    "SELECT 
    students.*,

    IFNULL(
        
        ROUND(AVG(performance_data.pf_rating),2),
        'Unrated'
    

    ) AS rating

    FROM students LEFT JOIN performance_data ON 
    students.student_ID = performance_data.pf_userID AND students.student_username = performance_data.pf_username

    WHERE 
    students.student_ID = $user_id AND 
    students.student_username = '".$user_username."'

    ") or die(mysqli_error($conn));

    //set staff credential values
    $r_q_find_student = mysqli_fetch_assoc($q_find_student);

    $name = $r_q_find_student['student_lname'].", ".$r_q_find_student['student_lname']." ".$r_q_find_student['student_mname'];
    $lname = $r_q_find_student['student_lname'];
    $id = $r_q_find_student['student_ID'];
    $account_level = $r_q_find_student['student_accountLevel'];
    $rating = $r_q_find_student['rating'];

    // set request type
    $requestType = "studentupdate";

}

function properize($string) {
	return $string.'\''.($string[strlen($string) - 1] != 's' ? 's' : '');
}

?>

<html>
    <header>

        <title><?php echo properize($lname);?> Profile</title>
        <link href="css/bootstrap.css" rel="stylesheet" type="text/css"/>
        <link href="css/bootstrap.css" rel="stylesheet" type="text/css"/>
        <link href="css/global-style.css" rel="stylesheet" type="text/css"/>
        <link href="css/class-search.css" rel="stylesheet" type="text/css"/>
        <script src = "js/Chart.bundle.js"></script>
        <script src = "js/jquery.js"></script>

    </header>

    <body>

        <div><?php include 'widgets/navigation.php';?></div>

        <div><?php include 'widgets/logged_user.php';?></div>

        <!-- Main contnainer -->
        <div style = "height: 800px; margin: 0 auto;" class="col-lg-6 col-lg-offset-3" id="container">

            <!--User profile-->
            <div class="card">
                <div class="card-header">
                    User ID: #<?php echo $id;?>
                    <p class="card-text">
                        <?php 
                        switch($account_level){
                            case 1:
                            echo "<span class=\"badge badge-primary\">Administrator Account</span>";
                            break;

                            case 2:
                            echo "<span class=\"badge badge-success\">Teacher Account</span>";
                            break;

                            default:
                            echo "<span class=\"badge badge-secondary\">Student Account</span>";
                        }
                        ?><br>
                    </p>
                </div>
                
                <div class="card-body">
                    <h5 class="card-title"><?php echo $name;?></h5>

                    <div style = "margin-bottom: 15px;" id = "consistency">
                        
                        <span>User consistency</span>
                        <div class="progress">
                            <?php 
                            // user consistency display
                            if($rating != "Unrated"){

                                $progressbar_bg;

                                if($rating <= 25){
                                    $progressbar_bg = "bg-danger";
                                }else if($rating <= 50 && $rating > 25){
                                    $progressbar_bg = "bg-warning";
                                }else if($rating <= 75 && $rating > 50){
                                    $progressbar_bg = ""; // default
                                }else if($rating <= 100 && $rating > 75){
                                    $progressbar_bg = "bg-success";
                                }

                                echo 
                                '<div class="progress-bar '.$progressbar_bg.'" role="progressbar" style="width: '.$rating.'%;" aria-valuenow="'.$rating.'" aria-valuemin="0" aria-valuemax="100">
                                    '.$rating.'%
                                </div>';

                            }else{

                                echo 
                                '<div class="progress-bar bg-warning" role="progressbar" style="width: 100%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                    Unrated
                                </div>';

                            }
                            ?>
                        </div>

                    </div>
                    <a href="user-update.php?id=<?php echo $user_id;?>&request=<?php echo $requestType;?>&redirect=user-profile" class="btn btn-secondary">Update Profile</a>
                </div>
            </div>
            
            <!--Chart-->
            <div style = "margin-bottom: 20px;">
                <canvas style = "height: 200px; width: 100%" id = "performanceLineChart"></canvas>
            </div>

            <!--Test taken-->
            <h5>Test History</h5>
            <hr>
            <div style = "max-height: 270px; overflow-y: auto; border-style: thin; border-color: silver; height: 270px; width: 100%">
                <table class="table table-sm table-hover">
                <thead>
                    <tr>
                    <th scope="col">Test ID#</th>
                    <th scope="col">Test Name</th>
                    <th scope="col">Rating</th>
                    </tr>
                </thead>

                <tbody>
                    <?php

                    $performance = array();

                    if($rating != "Unrated"){
                    
                        $q_performance = mysqli_query($conn,
                        "SELECT 
                        performance_data.*,
                        tests.test_name,
                        tests.test_ID,
                        tests.test_type
                        
                        FROM `performance_data` LEFT JOIN tests 
                        ON performance_data.pf_testID = tests.test_ID
                        
                        WHERE 
                        performance_data.pf_userID = $user_id AND
                        performance_data.pf_username = '".$user_username."'
                        
                        ORDER BY performance_data.pf_timestamp ASC LIMIT 5
                        ");
                    
                        while($r_performance = mysqli_fetch_array($q_performance, MYSQLI_ASSOC)){
                    
                            // store values as an array for the chart
                            $performance[] = $r_performance;

                            // display table contents
                            echo '<tr>';
                            echo '<th scope="row">'.$r_performance['test_ID'].'</th>';
                            echo '<td>['.$r_performance['test_type'].'] '.$r_performance['test_name'].'</td>';
                            echo '<td>'.$r_performance['pf_rating'].'%</td>';
                            echo '</tr>';
                    
                        }

                    }
                    ?>
                </tbody>
                </table>
            </div>

        </div>

    </body>

    <script type="text/javascript" language="javascript">
        $(document).ready(function(){

            var chart = $('#performanceLineChart')[0].getContext('2d');
            var performanceValues = <?php echo json_encode($performance)?>;

            //console.log(performanceValues);

            var performance_chart = new Chart(chart, {
                type: 'line',
                data: {
                    labels: [],
                    datasets: [{
                        label: 'Historical Performance graph',
                        data: [],
                        backgroundColor: [
                            'rgba(134,26,192,.5)'
                        ],
                        borderColor: [
                            'rgba(68, 25, 91, 1)'
                        ],
                        borderWidth: 1,
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                suggestedMin: 0,
                                suggestedMax: 100,
                                beginAtZero:true
                            }
                        }]
                    }
                }
            }); 

            for(let i = 0; i < performanceValues.length; i++){
                performance_chart.data.labels[i] = performanceValues[i].test_name;
                performance_chart.data.datasets[0].data[i] = performanceValues[i].pf_rating;
            }
            performance_chart.update();
        });
    </script>
</html>