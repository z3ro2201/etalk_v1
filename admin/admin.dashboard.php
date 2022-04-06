<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/admin.header.php";?>
<?
    $today = date('Y-m-d');
    if(!$_GET['days']) $days=$today;
    else $days=$_GET['days'];
$member_count = $db->query("SELECT COUNT(*) AS cnt FROM chk_user")->fetch_assoc();
    $normal = $db->query("SELECT COUNT(*) as normal FROM check_report WHERE user_val = '0' AND regdate = '$days'")->fetch_assoc()['normal']; // 정상
    $confirm = $db->query("SELECT COUNT(*) as confirm FROM check_report WHERE user_val >= '1' AND regdate = '$days'")->fetch_assoc()['confirm']; // 확인필요
    $tot = $db->query("SELECT COUNT(*) as confirm FROM check_report WHERE regdate = '$days'")->fetch_assoc();

    $nope = $member_count['cnt'] - $tot['confirm'];
  ?>
<div style="float:left;width:50%;height:500px;overflow:hidden;">
  <canvas id="chunil"></canvas>
</div>
<div style="float:left;width:50%;height:550px;">
  <div style="float:left;width:100%;height:250px;overflow:hidden;">
    <canvas id="myChart"></canvas>
  </div>
  <div style="float:left;width:100%;height:250px;overflow:hidden;">
    <canvas id="covid19"></canvas>
  </div>
</div>
<script>
$(function() {
  var s_dt = new Array();
  var s_hj = new Array();
  var sn_hj = new Array();
  var s_care = new Array();
  var s_recover = new Array();
  var sn_recover = new Array();
  var s_death = new Array();
  var t_dt = new Array();
  var t_hj = new Array();
  var n_hj = new Array();
  var ty_care = new Array();
  var recover = new Array();
  var death = new Array();

  var ctx = document.getElementById('myChart').getContext('2d');
  var covid19 = document.getElementById('covid19').getContext('2d');
  var chunil = document.getElementById('chunil').getContext('2d');

  $.getJSON('/api/TbCorona19CountStatusJCG.php', function(data) {
    console.log(data.TbCorona19CountStatus.row);
    $.each(data.TbCorona19CountStatus.row, function(i, v) {
      s_dt.push(v.S_DT);
      s_hj.push(v.S_HJ);
      sn_hj.push(v.SN_HJ);
      s_care.push(v.S_CARE);
      s_recover.push(v.S_RECOVER);
      sn_recover.push(v.SN_RECOVER);
      s_death.push(v.S_DEATH);
      t_dt.push(v.T_DT);
      t_hj.push(v.T_HJ);
      n_hj.push(v.N_HJ);
      ty_care.push(v.TY_CARE);
      recover.push(v.RECOVER);
      death.push(v.DEATH);
    });
    s_dt.reverse();
    s_hj.reverse();
    sn_hj.reverse();
    s_care.reverse();
    s_recover.reverse();
    sn_recover.reverse();
    s_death.reverse();
    t_dt.reverse();
    t_hj.reverse();
    n_hj.reverse();
    ty_care.reverse();
    recover.reverse();
    death.reverse();
    console.log(s_hj);

    var myChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels : s_dt,
        datasets : [
        {
          label: '누적확진자',
          data: s_hj,
          backgroundColor: [
            'rgba(255, 99, 132, 0.2)',
            ],
          borderColor: [
            'rgba(255, 99, 132, 1)'
          ],
          borderWidth: 1
        },
        {
          label: '추가확진자',
          data: sn_hj,
          backgroundColor: [
            'rgba(54, 162, 235, 0.2)'
            ],
          borderColor: [
            'rgba(54, 162, 235, 1)'
          ],
          borderWidth: 1
        },
        {
          label: '치료중',
          data: s_care,
          backgroundColor: [
            'rgba(75, 192, 192, 0.2)'
            ],
          borderColor: [
            'rgba(75, 192, 192, 1)'
          ],
          borderWidth: 1
        },
        {
          label: '누적 퇴원자',
          data: s_recover,
          backgroundColor: [
            'rgba(153, 102, 255, 0.2)'
            ],
          borderColor: [
            'rgba(153, 102, 255, 1)'
          ],
          borderWidth: 1
        },
        {
          label: '추가 퇴원자',
          data: sn_recover,
          backgroundColor: [
            'rgba(133, 102, 255, 0.2)'
            ],
          borderColor: [
            'rgba(133, 102, 255, 1)'
          ],
          borderWidth: 1
        },
        {
          label: '사망자',
          data: s_death,
          backgroundColor: [
            'rgba(255, 159, 64, 0.2)'
            ],
          borderColor: [
            'rgba(255, 159, 64, 1)'
          ],
          borderWidth: 1
        }
        ]
      },
       options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: 'top',
          },
          title: {
            display: true,
            text: '서울특별시 코로나 19 현황'
          }
        },
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero: true
            }
          }]
        }
      }
    });



    var covid19Chart = new Chart(covid19, {
      type: 'bar',
      data: {
        labels : t_dt,
        datasets : [
        {
          label: '누적확진자',
          data: t_hj,
          backgroundColor: [
            'rgba(255, 99, 132, 0.2)',
            ],
          borderColor: [
            'rgba(255, 99, 132, 1)'
          ],
          borderWidth: 1
        },
        {
          label: '추가확진자',
          data: n_hj,
          backgroundColor: [
            'rgba(54, 162, 235, 0.2)'
            ],
          borderColor: [
            'rgba(54, 162, 235, 1)'
          ],
          borderWidth: 1
        },
        {
          label: '치료중',
          data: ty_care,
          backgroundColor: [
            'rgba(75, 192, 192, 0.2)'
            ],
          borderColor: [
            'rgba(75, 192, 192, 1)'
          ],
          borderWidth: 1
        },
        {
          label: '누적 퇴원자',
          data: recover,
          backgroundColor: [
            'rgba(153, 102, 255, 0.2)'
            ],
          borderColor: [
            'rgba(153, 102, 255, 1)'
          ],
          borderWidth: 1
        },
        {
          label: '사망자',
          data: death,
          backgroundColor: [
            'rgba(255, 159, 64, 0.2)'
            ],
          borderColor: [
            'rgba(255, 159, 64, 1)'
          ],
          borderWidth: 1
        }
        ]
      },
       options: {
         responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: 'top',
          },
          title: {
            display: true,
            text: '전국 코로나 19 현황'
          }
        },
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero: true
            }
          }]
        }
      }
    })
    
  });

var chunilChart = new Chart(chunil, {
      type: 'doughnut',
      data: {
        labels : ['정상(<?=$normal;?>명)','유증상(<?=$confirm;?>명)','미참여(<?=$nope;?>명)'],
        datasets : [
        {
          //label: ['정상', '유증상', '미참여'],
          data: ['<?=$normal;?>', '<?=$confirm;?>', '<?=$nope;?>'],
          backgroundColor: [
            'rgba(54, 162, 235, 0.2)',
            'rgba(255, 99, 132, 0.2)',
            'rgba(75, 192, 192, 0.2)'
            ],
          borderColor: [         
            'rgba(54, 162, 235, 1)',
            'rgba(255, 99, 132, 1)',   
            'rgba(75, 192, 192, 1)'
          ],
          borderWidth: 1
        }]
      },
       options: {
         responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: 'top',
          },
          title: {
            display: true,
            text: '오늘의 건강상태 자가진단 참여 현황'
          }
        },
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero: true
            }
          }]
        }
      }
    })
})
</script>
<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/admin.footer.php";?>