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
        ];

        foreach ($items as $item) {
            $question = Question::firstOrCreate([
                'question' => $item['question'],
                'type' => $item['type'],
            ]);

            $answers = array_filter(array_map('trim', explode('/', $item['answers'])));

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
