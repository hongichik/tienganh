<?php

namespace App\Models;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AI
{
    public const GPT_5_4_NANO = 'gpt-5.4-nano';

    public static function generateQuestions()
    {
        $data = (new self())->chatCompletionText(
            '
                Bạn là AI tạo câu hỏi luyện nói tiếng Anh giao tiếp.

                Quy tắc:
                - Tạo đúng 20 câu hỏi.
                - Độ khó từ A1 đến B1.
                - Chủ đề đa dạng:
                + bản thân
                + gia đình
                + bạn bè
                + học tập
                + công việc
                + công nghệ
                + du lịch
                + đồ ăn
                + sức khỏe
                + thể thao
                + âm nhạc
                + phim ảnh
                + mạng xã hội
                + thời tiết
                + kế hoạch tương lai
                + trải nghiệm quá khứ
                + thói quen
                + cảm xúc
                + mua sắm
                + cuộc sống hàng ngày
                - Câu hỏi tự nhiên như người bản xứ.
                - Không lặp lại ý.
                - Mỗi câu tối đa 15 từ.
                - Ưu tiên câu dễ trả lời ngắn.

                Yêu cầu:
                - Chỉ trả về JSON array hợp lệ.
                - Không markdown.
                - Không giải thích.
                - Format:
                [
                "Question 1?",
                "Question 2?"
                ]
                ',
                'Tạo 20 câu hỏi tiếng Anh giao tiếp đa chủ đề.'
        );

        return json_decode($data['content'], true);
    }

    public static function AIReplyPart1($question, $answer)
    {
        $data = (new self())->chatCompletionText(
            'Bạn là AI kiểm tra câu trả lời tiếng Anh ngắn.
                Quy tắc:
                - Chỉ chấp nhận câu trả lời từ 1–5 từ.
                - Kiểm tra ngữ pháp, chính tả, viết hoa và dấu chấm cuối câu.
                - Thiếu dấu chấm cuối câu => trạng_thai = 2.
                - Câu gợi ý tiếng anh phải ngắn gọn, tự nhiên, dễ hiểu, không quá 5 câu.

                Trạng thái:
                - 1 = đúng hoàn toàn
                - 2 = gần đúng, có lỗi nhỏ
                - 0 = sai hoặc vượt quá 5 từ

                Yêu cầu:
                - Trả đúng JSON:
                {
                "trang_thai": 0|1|2,
                "goiy": "..."
                }
                - "goiy" phải ngắn gọn, tự nhiên, dễ hiểu.
                - Nếu đúng: khen ngắn gọn và xác nhận đúng.
                - Nếu gần đúng: nói lỗi cần sửa và đưa câu đúng hoàn chỉnh.
                - Nếu sai: hướng dẫn câu trả lời phù hợp.
                - Gợi ý tối đa 5 câu.
            ',
            'Câu hỏi: ' . $question . ' Trả lời: ' . $answer,
        );
        return json_decode($data['content'], true);
    }

    public static function AIAnalyzePart1Hint($question)
    {
        $data = (new self())->chatCompletionText(
            'Bạn là một chuyên gia ngôn ngữ học và luyện thi IELTS/CEFR. Phân tích câu hỏi tiếng Anh theo các mục sau:

1. **Giải nghĩa & Ngữ pháp**
   - Dịch nghĩa: Dịch câu hỏi sang tiếng Việt (1 dòng).
   - Thì (Tense): Tên thì của câu hỏi (VD: Present Simple, Present Continuous).
   - Từ khóa: 2-3 từ quan trọng nhất.

2. **Ngữ cảnh**: (VD: Đời thường, Công việc, Học thuật, Bạn bè).

3. **Công thức trả lời**: Cấu trúc [Subject] + [Verb-chia theo thì] + [Object/Adverb]. Dùng ký hiệu V-ing, V-ed, V-bare.

4. **Gợi ý trả lời**
   - Ngắn gọn: (1 câu trực tiếp).
   - Mở rộng: (2-3 câu chi tiết).
   - Lý do dùng thì: Giải thích tại sao dùng thì đó.

Yêu cầu:
- Trả về JSON hợp lệ.
- Không markdown, không giải thích thêm.
- Trả lời súc tích, không rườm rà.
- Phải sử dụng tiếng Anh (ngoài dịch Việt).
- Format JSON (key: dich_nghia, tense, tu_khoa, ngữ_cảnh, cong_thuc, tro_loi_ngan_gon, tro_loi_mo_rong, ly_do_thì).

Trả về JSON:
{
  "dich_nghia": "...",
  "tense": "...",
  "tu_khoa": "...",
  "ngữ_cảnh": "...",
  "cong_thuc": "...",
  "tro_loi_ngan_gon": "...",
  "tro_loi_mo_rong": "...",
  "ly_do_thì": "..."
}
            ',
            'Phân tích câu hỏi: ' . $question,
        );

        return json_decode($data['content'], true);
    }

    private function chatCompletionText(
        string $developerText,
        ?string $userText = null,
        ?string $verbosity = "low",
        ?string $reasoningEffort = "none",
        ?string $returnType = 'data',
        array $overrides = []
    ): ?array {
        $apiKey = (string) env('OPENAI_API_KEY', '');
        $baseUrl = rtrim((string) ($overrides['base_url'] ?? env('OPENAI_BASE_URL', 'https://api.openai.com/v1')), '/');
        $model = (string) ($overrides['model'] ?? self::GPT_5_4_NANO);
        $timeout = (int) ($overrides['timeout'] ?? 30);

        if ($apiKey === '') {
            Log::warning('ai.chat_completion_text_missing_api_key');
            return null;
        }

        $messages = $overrides['messages'] ?? [
            self::textMessage('developer', $developerText),
        ];

        if (! array_key_exists('messages', $overrides)) {
            if ($userText !== null && trim($userText) !== '') {
                $messages[] = self::textMessage('user', $userText);
            }
        }

        $payload = [
            'model' => $model,
            'messages' => $messages,
            'response_format' => [
                'type' => 'text',
            ],
            'verbosity' => $verbosity,
            'reasoning_effort' => $reasoningEffort,
            'store' => false,
        ];

        try {
            $response = Http::timeout($timeout)
                ->withToken($apiKey)
                ->acceptJson()
                ->post($baseUrl . '/chat/completions', $payload);

            if (! $response->successful()) {
                Log::warning('ai.chat_completion_text_failed', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                return null;
            }
            if ($returnType === 'data') {
                return data_get($response->json(), 'choices.0.message');
            }
            return $response->json();
        } catch (\Throwable $exception) {
            Log::warning('ai.chat_completion_text_exception', [
                'message' => $exception->getMessage(),
            ]);

            return null;
        }
    }

    public static function extractTextFromResponse(?array $response): ?string
    {
        if (! is_array($response)) {
            return null;
        }

        $content = data_get($response, 'choices.0.message.content');

        if (! is_string($content)) {
            return null;
        }

        $content = trim($content);

        return $content !== '' ? $content : null;
    }

    /**
     * @return array<string, mixed>
     */
    private static function textMessage(string $role, string $text): array
    {
        return [
            'role' => $role,
            'content' => [
                [
                    'type' => 'text',
                    'text' => $text,
                ],
            ],
        ];
    }
}
