<?
header("Content-type: image/png");
$image = ImageCreate (300, 300); // 사이즈가 300x300인 이미지 생성
$color_black = ImageColorAllocate ($image, 0x00, 0x00, 0x00); // 검정색을 설정
$color_white = ImageColorAllocate ($image, 0xFF, 0xFF, 0xFF); // 흰색을 설정
ImageTTFtext ($image, 30, 45, 100, 150, $color_white, "tahoma.ttf", "navyism"); // (100,150)에 navyism을 입력
ImageGif ($image); // 이미지 출력
ImageDestroy ($image); // 메모리에서 이미지 제거
?>  