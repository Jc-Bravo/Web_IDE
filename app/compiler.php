<?php
/*
2022/7/26 唐子涵：
    添加编译器的环境路径
    将exe存储于temp/中（原先在app中）
*/
    $language = strtolower($_POST['language']);
    $code = $_POST['code'];

    // 在temp中新建文件并加密文件名。将代码写入文件。
    $random = substr(md5(mt_rand()), 0, 7);
    $filePath = "temp/" . $random . "." . $language;
    $programFile = fopen($filePath, "w");
    fwrite($programFile, $code);
    fclose($programFile);

    if($language == "php") {
        $output = shell_exec("php $filePath || C:\php8.0.21\php.exe $filePath 2>&1");
        echo $output;
    }
    if($language == "python") {
        $output = shell_exec("python $filePath || C:\Python310\python.exe $filePath 2>&1");
        echo $output;
    }
    if($language == "node") {
        rename($filePath, $filePath.".js");
        $output = shell_exec("node $filePath.js 2>&1");
        echo $output;
    }
    if($language == "c") {
        $outputExe = "temp/" . $random . ".exe";
        shell_exec("gcc $filePath -o $outputExe");
        $output = shell_exec(__DIR__ . "//$outputExe");
        echo $output;
    }
    if($language == "cpp") {
        $outputExe = "temp/" . $random . ".exe";
        shell_exec("g++ $filePath -o $outputExe");
        $output = shell_exec(__DIR__ . "//$outputExe");
        echo $output;
    }