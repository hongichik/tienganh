<?php

namespace Database\Seeders;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Database\Seeder;

class WritingQuestionAnswerSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'question' => "What's your favourite sport?",
                'type' => 'viet1',
                'answers' => 'My favourite sport is football./ I love football./ It\'s football/ I am into football/ I am fond of football.',
            ],
            [
                'question' => 'How many people are there in your family?',
                'type' => 'viet1',
                'answers' => '4 people/ There are 4 people/ My family has 4 people.',
            ],
            [
                'question' => 'What did you do yesterday?',
                'type' => 'viet1',
                'answers' => 'I stayed at home/ I went to school./ I went out with friends.',
            ],
            [
                'question' => 'How do you go to school?',
                'type' => 'viet1',
                'answers' => 'By car/ I drive to school/ I walk to school.',
            ],
            [
                'question' => "What's your hobby?",
                'type' => 'viet1',
                'answers' => 'My hobby is playing sports./ It is playing sports/ I love playing sports.',
            ],
            [
                'question' => 'What do you like to do in the evening?',
                'type' => 'viet1',
                'answers' => 'I like to watch TV/ I enjoy watching TV.',
            ],
            [
                'question' => 'What is your favorite device?',
                'type' => 'viet1',
                'answers' => "It's my iPhone/ I love the CD player.",
            ],
            [
                'question' => 'Where would you like to live?',
                'type' => 'viet1',
                'answers' => 'In Hanoi/ In the countryside/ In a big city.',
            ],
            [
                'question' => 'Do you often use Facebook?',
                'type' => 'viet1',
                'answers' => 'I use Facebook every day.',
            ],
            [
                'question' => 'What do you do?',
                'type' => 'viet1',
                'answers' => 'I work as a teacher/ I am a teacher.',
            ],
            [
                'question' => 'Where do you live?',
                'type' => 'viet1',
                'answers' => 'In Hanoi/ I live in Hanoi/ I live in a village.',
            ],
            [
                'question' => 'What do you do to keep fit?',
                'type' => 'viet1',
                'answers' => 'I play sports.',
            ],
            [
                'question' => "What's your favourite kind of music?",
                'type' => 'viet1',
                'answers' => "It's Pop music/ I love Pop music.",
            ],
            [
                'question' => 'What do you often do in your free time?',
                'type' => 'viet1',
                'answers' => 'I often play sports',
            ],
            [
                'question' => 'What is your surname?',
                'type' => 'viet1',
                'answers' => 'It is Nguyen/ My surname is Nguyen.',
            ],
            [
                'question' => 'What is your favourite animal?',
                'type' => 'viet1',
                'answers' => 'I really love cats.',
            ],
            [
                'question' => 'What time do you get up every day?',
                'type' => 'viet1',
                'answers' => 'At 6AM/ I get up at 6AM.',
            ],
            [
                'question' => 'What language do you speak?',
                'type' => 'viet1',
                'answers' => "I speak English/ It's English",
            ],
            [
                'question' => 'How many people are there in your family?',
                'type' => 'viet1',
                'answers' => 'There are 4 people.',
            ],
            [
                'question' => 'Do you like drink coffee?',
                'type' => 'viet1',
                'answers' => 'Yes, I do/ I really love coffee.',
            ],
            [
                'question' => "What's your favourite color?",
                'type' => 'viet1',
                'answers' => "I love red/ It's red",
            ],
            [
                'question' => 'What are you wearing today?',
                'type' => 'viet1',
                'answers' => 'I am wearing a dress.',
            ],
            [
                'question' => "What's the weather like today?",
                'type' => 'viet1',
                'answers' => "It's hot.",
            ],
            [
                'question' => 'How is the room you are in?',
                'type' => 'viet1',
                'answers' => "It's big",
            ],
            [
                'question' => 'How did you come here?',
                'type' => 'viet1',
                'answers' => 'By car/ I came here by car.',
            ],
            [
                'question' => 'What do you often do in your free time? (20-30 words) (Book Club)',
                'type' => 'viet2',
                'answers' => [
                    'In my free time, I often play sports because it is enjoyable and good for my health. It helps me relax after work and improve my health.',
                    'In my spare time, I often play sports because it is enjoyable and beneficial for my health. It enables me to relax after work and improve my mental and physical health.',
                ],
            ],
            [
                'question' => 'Please tell me the last time you listened to music. (Music Club)',
                'type' => 'viet2',
                'answers' => [
                    'The last time I listened to music was last week. I went to a cafe with my friends and we listened to music there. It was so relaxing.',
                    'The last time I listened to music was last week. I went to a cafe with my best friends and we enjoyed music there, which was so relaxing.',
                ],
            ],
            [
                'question' => 'Please tell me about your free time and hobbies? (Language Course)',
                'type' => 'viet2',
                'answers' => [
                    'In my free time, I often play sports because it is enjoyable and good for my health. It helps me relax after work and improve my health.',
                    'In my spare time, I often play sports because it is enjoyable and beneficial for my health. It enables me to relax after work and improve my mental and physical health.',
                ],
            ],
            [
                'question' => 'Please tell me about the last time you went to the/a museum? (20-30 words) (Museum Club)',
                'type' => 'viet2',
                'answers' => [
                    'The last time I went to a museum was last week. I went to an art museum in the city centre. There were a lot of paintings there.',
                    'Last week I went to an art museum located in the city centre. Numerous paintings of well-known artists were displayed there.',
                ],
            ],
            [
                'question' => 'Do you usually watch TV? (Television Club)',
                'type' => 'viet2',
                'answers' => [
                    'I watch TV every day, after dinner. I often watch TV with my family in the living room. It is really relaxing and enjoyable.',
                    'After a hard-working day, I often watch TV with my family in the evening, after dinner. For me, it is the best time of the day. Watching TV allows me to reduce stress and broaden my mind.',
                ],
            ],
            [
                'question' => 'Please tell us about the days and times you can attend courses and what you would like to study? (College Club)',
                'type' => 'viet2',
                'answers' => [
                    'I can attend courses on Monday and Friday, from 8AM to 11AM. I would like to study English and French.',
                    'I can take part in courses from Monday to Friday, between 8AM and 11AM. I am interested in English and French.',
                ],
            ],
            [
                'question' => 'When and where do you use a computer? (20-30 words) (Computer Club)',
                'type' => 'viet2',
                'answers' => [
                    'I often use a computer in the morning in my office. I use it to deal with a lot of work. In the evening, I use a computer to learn online.',
                    'I use my computer a lot for my work and my study. In the morning, I use my computer to deal with a lot of work in my office and in the evening, I use it to learn online.',
                ],
            ],
            [
                'question' => 'What do you usually use your laptop for? (Technology Club)',
                'type' => 'viet2',
                'answers' => [
                    'I use my laptop for a lot of things, especially study, work and entertainment. I can learn online, search for information, type a document and relax.',
                    'I use my laptop for numerous things, especially study, work and entertainment. I can learn online, get and send emails and watch interesting programs from Youtube.',
                ],
            ],
            [
                'question' => 'Do you like science? (Science Club)',
                'type' => 'viet2',
                'answers' => [
                    'I like science. I can watch science programs on TV every day because it is really interesting and useful. It helps me understand more about the world.',
                    'I find a lot of interest in science as it is really interesting and useful. It helps people understand more about natural phenomena or the development of all things.',
                ],
            ],
            [
                'question' => 'Describe where you live (Home Living Club)',
                'type' => 'viet2',
                'answers' => [
                    'I have a big house in the outskirt of Hanoi City. There are six rooms with a garden in front of the house. It was built 10 years ago when I was small.',
                ],
            ],
            [
                'question' => 'Why are you interested in travel? (Travel Club)',
                'type' => 'viet2',
                'answers' => [
                    'I love travel because it is enjoyable. It can help me relax and reduce stress after hard-working days. Besides, it allows me to broaden my mind.',
                ],
            ],
            [
                'question' => 'Why did you decide to join the club? (Cooking Club)',
                'type' => 'viet2',
                'answers' => [
                    'I take part in the club because I love cooking and I can meet many people who have the same hobby as me.',
                    'I join the club as I find a lot of interest in cooking. Also, I want to learn more about cooking and make friends with those who have the same hobby as me.',
                ],
            ],
        ];

        foreach ($items as $item) {
            $question = Question::firstOrCreate([
                'question' => $item['question'],
                'type' => $item['type'],
            ]);

            if (is_array($item['answers'])) {
                $answers = array_filter(array_map('trim', $item['answers']));
            } else {
                $answers = array_filter(array_map('trim', explode('/', $item['answers'])));
            }

            foreach ($answers as $answerText) {
                Answer::firstOrCreate([
                    'question_id' => $question->id,
                    'user_id' => null,
                    'content' => $answerText,
                ]);
            }
        }
    }
}
