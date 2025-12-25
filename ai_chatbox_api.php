<?php
// PHP SẼ ĐƯỢC XỬ LÝ ĐẦU TIÊN
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. CẤU HÌNH BẢO MẬT: THAY THẾ KHÓA API CỦA BẠN TẠI ĐÂY
    $apiKey = ''; 
    $model = 'gemini-2.5-flash'; 

    header('Content-Type: application/json');

    $input = file_get_contents('php://input');
    $data = json_decode($input, true);
    $prompt = $data['prompt'] ?? '';

    if (empty($prompt)) {
        echo json_encode(['error' => 'Không có nội dung câu hỏi (prompt) được gửi.']);
        // BẮT BUỘC PHẢI DỪNG LẠI SAU KHI XUẤT JSON
        exit; 
    }


    // 2. CHUẨN BỊ YÊU CẦU GEMINI API
    $api_url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}";
    
    // ĐỊNH NGHĨA VAI TRÒ VÀ NỐI VÀO PROMPT
    $system_role = "Bạn là Zencha, trợ lý AI chuyên nghiệp của một cửa hàng bán trà xanh và các sản phẩm liên quan. Hãy trả lời các câu hỏi của khách hàng một cách thân thiện, lịch sự và tập trung vào sản phẩm. Nếu câu hỏi không liên quan, hãy nhẹ nhàng hướng khách hàng trở lại chủ đề trà. Câu hỏi của khách hàng là: ";
    $full_prompt = $system_role . $prompt; // Nối vai trò và câu hỏi

    $payload = json_encode([
        'contents' => [
            [
                'role' => 'user',
                'parts' => [
                    // Gửi toàn bộ prompt đã bao gồm vai trò hệ thống
                    ['text' => $full_prompt] 
                ]
            ]
        ],
        // CHỈ SỬ DỤNG generationConfig để điều chỉnh temperature
        'generationConfig' => [
            'temperature' => 0.2, // Mức độ sáng tạo (0.0-1.0)
        ]
        
    ]);

    // 3. GỌI API BẰNG cURL 
    $ch = curl_init($api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);

    // 4. XỬ LÝ PHẢN HỒI VÀ DỪNG CHƯƠNG TRÌNH
    if ($error) {
        echo json_encode(['error' => 'Lỗi cURL: ' . $error]);
        exit;
    }

    $responseData = json_decode($response, true);

    if ($http_code !== 200 || !isset($responseData['candidates'][0]['content']['parts'][0]['text'])) {
        $errorMessage = $responseData['error']['message'] ?? 'Lỗi không xác định từ Gemini API.';
        echo json_encode(['error' => 'Gemini API trả về lỗi: ' . $errorMessage . ' (HTTP ' . $http_code . ')']);
        exit;
    }

    $aiResponse = $responseData['candidates'][0]['content']['parts'][0]['text'];
    
    echo json_encode(['response' => $aiResponse]);
    exit; 
}
?>