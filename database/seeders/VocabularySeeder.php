<?php

namespace Database\Seeders;

use App\Models\Vocabulary;
use Illuminate\Database\Seeder;

class VocabularySeeder extends Seeder
{
    public function run(): void
    {
        Vocabulary::query()->get()->each(function (Vocabulary $vocabulary): void {
            $cleanedWord = $this->cleanEnglishWord($vocabulary->english_word);

            if ($cleanedWord === $vocabulary->english_word) {
                return;
            }

            $duplicate = Vocabulary::query()
                ->where('id', '!=', $vocabulary->id)
                ->where('english_word', $cleanedWord)
                ->first();

            if ($duplicate) {
                if ($duplicate->vietnamese_word === null && $vocabulary->vietnamese_word !== null) {
                    $duplicate->update(['vietnamese_word' => $vocabulary->vietnamese_word]);
                }

                $vocabulary->delete();

                return;
            }

            $vocabulary->update(['english_word' => $cleanedWord]);
        });

        $items = [
            ['english_word' => 'Member (n)', 'vietnamese_word' => 'thành viên'],
            ['english_word' => 'Attendee (n)', 'vietnamese_word' => 'người tham dự'],
            ['english_word' => 'Manager (n)', 'vietnamese_word' => 'quản lý'],
            ['english_word' => 'President (n)', 'vietnamese_word' => 'chủ tịch'],
            ['english_word' => 'Audience (n)', 'vietnamese_word' => 'khán giả'],
            ['english_word' => 'Expert (n)', 'vietnamese_word' => 'chuyên gia'],
            ['english_word' => 'Chef (n)', 'vietnamese_word' => 'đầu bếp'],
            ['english_word' => 'The chef will guide us how to cook a famous dish', 'vietnamese_word' => 'đầu bếp sẽ hướng dẫn chúng ta cách nấu một món ăn nổi tiếng'],
            ['english_word' => 'Designer (n)', 'vietnamese_word' => 'nhà thiết kế'],
            ['english_word' => 'Writer (n)', 'vietnamese_word' => 'nhà văn'],
            ['english_word' => 'Customer (n)', 'vietnamese_word' => 'khách hàng'],
            ['english_word' => 'Individual (n)', 'vietnamese_word' => 'cá nhân'],
            ['english_word' => 'Business (n)', 'vietnamese_word' => 'doanh nghiệp'],
            ['english_word' => 'Resident (n)', 'vietnamese_word' => 'cư dân'],
            ['english_word' => 'Adult (n)', 'vietnamese_word' => 'người lớn'],
            ['english_word' => 'Organizer (n)', 'vietnamese_word' => 'nhà tổ chức'],
            ['english_word' => 'Representative (n)', 'vietnamese_word' => 'đại diện'],
            ['english_word' => 'Inventor (n)', 'vietnamese_word' => 'nhà phát minh'],
            ['english_word' => 'Scientist (n)', 'vietnamese_word' => 'nhà khoa học'],
            ['english_word' => 'Community (n)', 'vietnamese_word' => 'cộng đồng'],
            ['english_word' => 'Organization (n)', 'vietnamese_word' => 'tổ chức'],
            ['english_word' => 'Local government (n)', 'vietnamese_word' => 'chính quyền địa phương'],
            ['english_word' => 'Plan (n, v)', 'vietnamese_word' => 'kế hoạch, lên kế hoạch'],
            ['english_word' => 'I am so excited about the plan', 'vietnamese_word' => null],
            ['english_word' => 'Our club is planning to organize an exhibition', 'vietnamese_word' => null],
            ['english_word' => 'Exhibition (n)', 'vietnamese_word' => null],
            ['english_word' => 'A monthly face-to-face meeting (n)', 'vietnamese_word' => 'cuộc họp trực tiếp hàng tháng'],
            ['english_word' => 'Organize an exhibition (n)', 'vietnamese_word' => 'tổ chức một triển lãm'],
            ['english_word' => 'Event (n)', 'vietnamese_word' => 'sự kiện'],
            ['english_word' => 'Meeting (n)', 'vietnamese_word' => 'cuộc họp, gặp'],
            ['english_word' => 'Contest (n)', 'vietnamese_word' => 'cuộc thi'],
            ['english_word' => 'Activity (n)', 'vietnamese_word' => 'hoạt động'],
            ['english_word' => 'Project (n)', 'vietnamese_word' => 'dự án'],
            ['english_word' => 'Concert (n)', 'vietnamese_word' => 'buổi biểu diễn nhạc'],
            ['english_word' => 'Equipment (n)', 'vietnamese_word' => 'thiết bị'],
            ['english_word' => 'Entry fee (n)', 'vietnamese_word' => 'phí vào cửa'],
            ['english_word' => 'Entrance fee (n)', 'vietnamese_word' => 'phí vào cửa'],
            ['english_word' => 'Attract (v)', 'vietnamese_word' => 'thu hút'],
            ['english_word' => 'Encourage (v)', 'vietnamese_word' => 'khuyến khích'],
            ['english_word' => 'We should encourage people to read books', 'vietnamese_word' => null],
            ['english_word' => 'Take part in (v)', 'vietnamese_word' => 'tham gia'],
            ['english_word' => 'Join (v)', 'vietnamese_word' => 'tham gia'],
            ['english_word' => 'Participate in (v)', 'vietnamese_word' => 'tham gia'],
            ['english_word' => 'Take place (v)', 'vietnamese_word' => 'diễn ra'],
            ['english_word' => 'Create (v)', 'vietnamese_word' => 'tạo ra'],
            ['english_word' => 'Cut costs (v)', 'vietnamese_word' => 'cắt giảm chi phí'],
            ['english_word' => 'Fund (n, v)', 'vietnamese_word' => 'ngân quỹ, tài trợ'],
            ['english_word' => 'To raise fund for homeless children, we can call for sponsorship from local government, businesses and individuals', 'vietnamese_word' => 'để gây quỹ cho trẻ em vô gia cư, chúng ta có thể kêu gọi tài trợ từ chính quyền địa phương, doanh nghiệp và cá nhân'],
            ['english_word' => 'Support (v, n)', 'vietnamese_word' => 'hỗ trợ'],
            ['english_word' => 'Promote (v)', 'vietnamese_word' => 'quảng bá'],
            ['english_word' => 'We can promote the event on social networking sites', 'vietnamese_word' => null],
            ['english_word' => 'It would be better for us to promote the local tourist attractions on social platforms', 'vietnamese_word' => null],
            ['english_word' => 'Attend (v)', 'vietnamese_word' => 'tham dự'],
            ['english_word' => 'Facilities (n)', 'vietnamese_word' => 'trang thiết bị'],
            ['english_word' => 'Annoy people around you', 'vietnamese_word' => 'làm phiền mọi người xung quanh'],
            ['english_word' => 'Nominate two representatives', 'vietnamese_word' => 'cử 2 đại diện'],
            ['english_word' => 'Prepare to welcome a group of foreign tourists', 'vietnamese_word' => 'chuẩn bị chào đón một nhóm du khách nước ngoài'],
            ['english_word' => 'Behave politely', 'vietnamese_word' => 'cư xử lịch sự'],
            ['english_word' => 'Raise your voice', 'vietnamese_word' => 'đưa ra ý kiến'],
            ['english_word' => 'Complain about the noise', 'vietnamese_word' => 'phàn nàn về tiếng ồn'],
            ['english_word' => 'Solve/fix/deal with the problem', 'vietnamese_word' => 'giải quyết vấn đề'],
            ['english_word' => 'Should a tax be imposed on unhealthy food?', 'vietnamese_word' => 'có nên áp thuế đối với đồ ăn không tốt cho sức khỏe'],
            ['english_word' => 'We should promote the event on social networking sites', 'vietnamese_word' => 'chúng ta nên quảng bá sự kiện trên các trang mạng xã hội'],
            ['english_word' => 'Have/hold a meeting', 'vietnamese_word' => 'tổ chức một cuộc họp'],
            ['english_word' => 'Organize an event', 'vietnamese_word' => 'tổ chức một sự kiện'],
            ['english_word' => 'Idea', 'vietnamese_word' => 'ý kiến'],
            ['english_word' => 'Creative idea', 'vietnamese_word' => 'sáng kiến'],
            ['english_word' => 'Offer/suggest some ideas', 'vietnamese_word' => 'đưa ra một vài ý kiến'],
            ['english_word' => 'Being a member of the club, I would like to offer some ideas', 'vietnamese_word' => null],
            ['english_word' => 'Suggestion (n)', 'vietnamese_word' => 'gợi ý'],
            ['english_word' => 'Proposal (n)', 'vietnamese_word' => 'đề xuất'],
            ['english_word' => 'Solution (n)', 'vietnamese_word' => 'giải pháp'],
            ['english_word' => "Raise people's awareness of traffic safety", 'vietnamese_word' => 'nâng cao ý thức người dân về an toàn giao thông'],
            ['english_word' => 'Educate people about the importance of home-made dishes', 'vietnamese_word' => 'giáo dục mọi người về tầm quan trọng của các món ăn nấu tại nhà'],
            ['english_word' => 'Feeling (n)', 'vietnamese_word' => 'cảm xúc'],
            ['english_word' => 'Post (v, n)', 'vietnamese_word' => 'đăng, bài đăng'],
            ['english_word' => 'Negative (adj, n)', 'vietnamese_word' => 'tiêu cực, ý kiến tiêu cực'],
            ['english_word' => 'Course (n)', 'vietnamese_word' => 'khóa học'],
            ['english_word' => 'Apartment (n)', 'vietnamese_word' => 'căn hộ'],
            ['english_word' => "Cover the museum's maintenance cost", 'vietnamese_word' => 'trang trải chi phí bảo trì của viện bảo tàng'],
            ['english_word' => 'Unrealistic (adj)', 'vietnamese_word' => 'không thực tế'],
            ['english_word' => 'Category (n)', 'vietnamese_word' => 'hạng mục'],
            ['english_word' => 'The club will be divided into several categories', 'vietnamese_word' => null],
            ['english_word' => 'Local authority', 'vietnamese_word' => 'chính quyền địa phương'],
        ];

        $items = collect($items)
            ->map(function (array $item): array {
                $item['english_word'] = $this->cleanEnglishWord($item['english_word']);

                return $item;
            })
            ->unique('english_word')
            ->values()
            ->all();

        foreach ($items as $item) {
            Vocabulary::query()->updateOrCreate(
                ['english_word' => $item['english_word']],
                ['vietnamese_word' => $item['vietnamese_word']]
            );
        }
    }

    private function cleanEnglishWord(string $value): string
    {
        $value = trim($value);

        return trim((string) preg_replace('/\s*\(([a-z,\.\s]+)\)\s*$/i', '', $value));
    }
}
