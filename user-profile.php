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

    $name = $r_q_find_student['student_lname'].", ".$r_q_find_student['student_fname']." ".$r_q_find_student['student_mname'];
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
        <div style = "height: 1030px; margin: 0 auto;" class="col-lg-6 col-lg-offset-3" id="container">

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
                    <a href="user-update.php?id=<?php echo $user_id;?>&request=<?php echo $requestType;?>&redirect=user-profile<?php if(isset($_GET['accproperty'])){echo '&accproperty='.$_GET['accproperty'];}?>" class="btn btn-secondary">Update Profile</a>
                </div>
            </div>
            
            <!--Chart-->
            <div style = "margin-bottom: 20px;">
                <canvas style = "height: 200px; width: 100%" id = "performanceLineChartPre"></canvas>
            </div>

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
                    <th scope="col">Mode</th>
                    <th scope="col">Rating</th>
                    <th scope="col">Date</th>
                    </tr>
                </thead>

                <tbody>
                    <?php

                    $performance = array();

                    if($rating != "Unrated"){
                        // post-test
                        $q_performance = mysqli_query($conn,
                        "SELECT 
                        IFNULL(tests.test_name, '[Removed]') as test_name,
                        IFNULL(tests.test_type, '[Removed]') as test_type,
                        performance_data.*
                                                
                        FROM (
                            SELECT * 
                            FROM performance_data 
                            WHERE 
                            performance_data.pf_userID = $user_id AND
                            performance_data.pf_username = '".$user_username."'
                            ORDER BY performance_data.pf_timestamp DESC
                        )performance_data
                        
                        LEFT JOIN tests 
                        ON performance_data.pf_testID = tests.test_ID
                        
                        WHERE
                        performance_data.pf_testMode = 'POST'
                                             
                        ORDER BY pf_timestamp DESC LIMIT 5
                        ");

                        while($r_performance = mysqli_fetch_array($q_performance, MYSQLI_ASSOC)){
                            // store values as an array for post-test chart
                            $performance[] = $r_performance;
                        }

                        //pre-test
                        $q_pre_performance = mysqli_query($conn,
                        "SELECT 
                        IFNULL(tests.test_name, '[Removed]') as test_name,
                        IFNULL(tests.test_type, '[Removed]') as test_type,
                        performance_data.*
                                                
                        FROM (
                            SELECT * 
                            FROM performance_data 
                            WHERE 
                            performance_data.pf_userID = $user_id AND
                            performance_data.pf_username = '".$user_username."'
                            ORDER BY performance_data.pf_timestamp DESC
                        )performance_data

                        LEFT JOIN tests 
                        ON performance_data.pf_testID = tests.test_ID

                        WHERE
                        performance_data.pf_testMode = 'PRE'
                                            
                        ORDER BY pf_timestamp DESC LIMIT 5
                        ");

                        $q_test_history = mysqli_query($conn,
                        "SELECT 
                        tests.test_ID,
                        IFNULL(tests.test_name, '[Removed Test]') as test_name,
                        IFNULL(CONCAT('[',tests.test_type,']'), '') as test_type,
                        performance_data.*
                        
                        FROM performance_data LEFT JOIN tests 
                        ON performance_data.pf_testID = tests.test_ID
                        
                        WHERE 
                        performance_data.pf_userID = $user_id AND
                        performance_data.pf_username = '".$user_username."' 
                        
                        ORDER BY pf_timestamp DESC
                        ");

                        while($r_pre_performance = mysqli_fetch_array($q_pre_performance, MYSQLI_ASSOC)){
                            // store values as an array for post-test chart
                            $pre_performance[] = $r_pre_performance;
                        }

                        while($r_test_history = mysqli_fetch_assoc($q_test_history)){

                            // display table contents
                            echo '<tr>';
                            echo '<th scope="row">'.$r_test_history['test_ID'].'</th>';
                            echo '<td>'.$r_test_history['test_type'].' '.$r_test_history['test_name'].'</td>';
                            echo '<td>'.$r_test_history['pf_testMode'].'</td>';
                            echo '<td>'.$r_test_history['pf_rating'].'%</td>';
                            echo '<td>'.date('dS F Y @ h:i:s A',strtotime($r_test_history['pf_timestamp'])).'</td>';
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
            var chartPre = $('#performanceLineChartPre')[0].getContext('2d');

            var pre_performanceValues = <?php echo json_encode($pre_performance)?>;
            var performanceValues = <?php echo json_encode($performance)?>;

            console.log(pre_performanceValues);

            //console.log(performanceValues);
            var pre_performance_chart = new Chart(chartPre, {
                type: 'line',
                data: {
                    labels: [],
                    datasets: [{
                        label: 'Pre-test',
                        data: [],
                        backgroundColor: [
                            'rgba(25, 181, 254, .5)'
                        ],
                        borderColor: [
                            
                            'rgba(0, 0, 255, 1)'
                        ],
                        borderWidth: 2,
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

            var performance_chart = new Chart(chart, {
                type: 'line',
                data: {
                    labels: [],
                    datasets: [{
                        label: 'Post-test',
                        data: [],
                        backgroundColor: [
                            'rgba(250, 190, 88, .5)'
                        ],
                        borderColor: [
                            
                            'rgba(0, 0, 255, 1)'
                        ],
                        borderWidth: 2,
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
            
            /*for(let i = pre_performanceValues.length - 1; i != 0; i--){
                console.log(i);
                pre_performance_chart.data.labels[i] = pre_performanceValues[i].test_name;
                pre_performance_chart.data.datasets[0].data[i] = pre_performanceValues[i].pf_rating;
                
            }

            // loop post-test
            for(let i = performanceValues.length - 1; i != 0; i--){
                performance_chart.data.labels[i] = performanceValues[i].test_name;
                performance_chart.data.datasets[0].data[i] = performanceValues[i].pf_rating;
            }*/
            
            var i = pre_performanceValues.length;
            do{
                i--;

                pre_performance_chart.data.labels[i] = pre_performanceValues[i].test_name.substring(0,13)+"...";
                pre_performance_chart.data.datasets[0].data[i] = pre_performanceValues[i].pf_rating;
                
            }while(i > 0)

            var post_i = performanceValues.length
            do{
                post_i--

                performance_chart.data.labels[post_i] = performanceValues[post_i].test_name.substring(0,13)+"...";
                performance_chart.data.datasets[0].data[post_i] = performanceValues[post_i].pf_rating;

            }while(post_i > 0)

            pre_performance_chart.update();
            performance_chart.update();
        });
    </script>
</html>