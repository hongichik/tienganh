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
            [
                'question' => 'Part 3: You are communicating with other members of the club in the chat room. Reply to their questions. Write in sentences. Use 30-40 words per answer. Recommended time: 10 minutes.',
                'type' => 'viet3',
                'meta' => [
                    'chat_prompts' => [
                        'Kim: I love new technology. Can you please tell me about the last time you used a computer to do something?',
                        'Marco: My grandmother does not know anything about computers. How can she learn about them? What should she do?',
                        'Sylvia: Young people spend too much time using computers. Some say it is not good for them. What is your opinion?',
                    ],
                ],
                'answers' => [
                    [
                        'position' => 1,
                        'content' => 'Last weekend I used my computer to design a presentation for our club meeting. I searched for pictures, edited slides, and practiced online. It saved me time and helped me explain my ideas more clearly to everyone.',
                    ],
                    [
                        'position' => 2,
                        'content' => 'She can start with basic lessons at a local center or watch simple videos with family support. She should practice using the keyboard, searching information, and sending messages every day. Step by step, she will feel more confident.',
                    ],
                    [
                        'position' => 3,
                        'content' => 'I think computers are useful, but young people need balance. Spending too long on screens can affect sleep and health. They should study and relax with technology, but also play sports, read books, and spend time with family.',
                    ],
                ],
            ],
            [
                'question' => 'Part 3: You are chatting in the health club forum. Reply to each member in 30-40 words.',
                'type' => 'viet3',
                'meta' => [
                    'chat_prompts' => [
                        'Anna: I often feel tired after work. What simple habits can help me stay healthy every day?',
                        'Peter: My brother wants to lose weight. What kind of exercise should he start with?',
                        'Linda: Some people skip breakfast to save time. Do you think that is a good idea?',
                    ],
                ],
                'answers' => [
                    [
                        'position' => 1,
                        'content' => 'You can start with small habits like drinking enough water, sleeping earlier, and walking for twenty minutes daily. Try to eat more vegetables and reduce sugary drinks. These simple changes can improve your energy and mood a lot.',
                    ],
                    [
                        'position' => 2,
                        'content' => 'He should begin with light exercise, such as brisk walking, cycling, or swimming three to four times a week. Later, he can add basic strength training. Starting slowly is safer and helps him build a routine without giving up quickly.',
                    ],
                    [
                        'position' => 3,
                        'content' => 'I do not think skipping breakfast is a good long-term habit. Breakfast gives you energy and helps you focus better. If you are busy, prepare something quick like fruit, yogurt, or bread the night before to save time.',
                    ],
                ],
            ],
            [
                'question' => 'Part 3: You are in a travel club chat room. Answer all three messages in complete sentences, 30-40 words each.',
                'type' => 'viet3',
                'meta' => [
                    'chat_prompts' => [
                        'Tom: I am planning my first trip to Da Nang. What places should I visit?',
                        'Mia: I always spend too much money when I travel. How can I save costs?',
                        'Eric: Is it better to travel alone or with friends? What do you prefer?',
                    ],
                ],
                'answers' => [
                    [
                        'position' => 1,
                        'content' => 'You should visit My Khe Beach, Ba Na Hills, and the Marble Mountains because they are very famous and beautiful. If you have time, enjoy local seafood and walk along the Han River at night for great views.',
                    ],
                    [
                        'position' => 2,
                        'content' => 'You can save money by booking tickets early, choosing budget hotels, and using public transport. Set a daily spending limit and avoid shopping without a plan. Also, try local food stalls because they are cheaper and delicious.',
                    ],
                    [
                        'position' => 3,
                        'content' => 'I prefer traveling with close friends because we can share costs, take photos together, and support each other. However, solo travel is also interesting when you want freedom and quiet time. It depends on your personality and purpose.',
                    ],
                ],
            ],
            [
                'question' => 'Part 3: You are discussing study skills in your class group chat. Reply to each student in around 30-40 words.',
                'type' => 'viet3',
                'meta' => [
                    'chat_prompts' => [
                        'Nora: I cannot remember new vocabulary for a long time. What should I do?',
                        'Jack: I get distracted when I study online. How can I concentrate better?',
                        'Helen: Some students study late at night every day. Do you think this is effective?',
                    ],
                ],
                'answers' => [
                    [
                        'position' => 1,
                        'content' => 'You should review vocabulary in small groups and use each word in your own sentences. Flashcards and short daily revision sessions are very helpful. If you repeat words regularly in speaking and writing, you will remember them longer.',
                    ],
                    [
                        'position' => 2,
                        'content' => 'Try studying in a quiet place and turn off social media notifications before class. Set a clear goal for each session and use short breaks every thirty minutes. This method helps your brain stay focused and reduces online distractions.',
                    ],
                    [
                        'position' => 3,
                        'content' => 'Studying late can work sometimes, but doing it every day is not ideal because it affects sleep quality. I think learning in the morning or evening with enough rest is more effective for memory, focus, and long-term health.',
                    ],
                ],
            ],
            [
                'question' => 'Part 4: Science Club Exhibition - give ideas for the event team and ticket policy.',
                'type' => 'viet4',
                'meta' => [
                    'intro_title' => 'Dear all members in our club,',
                    'intro_body' => 'Our club is preparing to organize the science exhibition next month. Both young people and elderly people can take part in our activities in the exhibition. Could you contribute some ideas for our event team? Whether our club issues tickets for participants? I would like to hear your contribution.',
                    'intro_signature' => 'Best, Ms Jenny - Manager.',
                    'task_1_instruction' => 'Write an email to your friend who is also a member of the club (about 50 words).',
                    'task_2_instruction' => 'Write an email to reply and express your feeling to Ms Jenny, manager of the club (about 120-150 words).',
                ],
                'answers' => [
                    [
                        'position' => 1,
                        'content' => 'Hi Anna, I have just read the latest email from our Science Club about the exhibition next month. I feel really excited because it sounds useful and fun. I think we should have simple experiments and low-cost tickets to manage participants better. Best, Mary.',
                    ],
                    [
                        'position' => 2,
                        'content' => 'Dear Manager, My name is Mary. I have been an active member of the club for the last six months. I am writing this email regarding the upcoming event mentioned in the latest announcement from our club. According to the email, our club is going to organize a science exhibition next month. To be honest, I was so excited to hear that news because it would be a great opportunity for me to meet all the members of the club and share scientific knowledge with others. Being a member of the club, I would like to offer some ideas. It is better for us to organize simple science experiments so that visitors can join and learn easily. I suggest we should sell low-cost tickets to manage the number of participants and support the club activities. Hopefully, my ideas will be helpful to our club. Best regards, Mary.',
                    ],
                ],
            ],
            [
                'question' => 'Part 4: Community Club - choose one of two projects and explain reasons.',
                'type' => 'viet4',
                'meta' => [
                    'intro_title' => 'Dear Member,',
                    'intro_body' => 'The Community Club is running two community projects. The first is to provide local sports facilities for children and young people. The second is to build parks with large gardens for the elderly. Which project do you think the club should do and why?',
                    'intro_signature' => 'Best, Club Manager.',
                    'task_1_instruction' => 'Write an email to your friend (about 50 words).',
                    'task_2_instruction' => 'Write an email to the manager and explain which option is better (about 120-150 words).',
                ],
                'answers' => [
                    [
                        'position' => 1,
                        'content' => 'Hi Anna, I have just received an email from our Community Club. They are planning two projects, but I think building sports facilities for children and young people is better. This project can help them stay healthy, active, and connected with friends. Best, Mary.',
                    ],
                    [
                        'position' => 2,
                        'content' => 'Dear Manager, My name is Mary. I have been an active member of the club for the last six months. I am writing this email regarding the upcoming plan mentioned in the latest announcement from our club. According to the email, our club is going to run two community projects for local people. To be honest, I was so excited to hear that news. Being a member of the club, I would like to offer some ideas. Among the two options, I believe that providing local sports facilities for children and young people is the best choice for some reasons. First, sports facilities will help young people exercise regularly and improve their health. Second, this project can create a safe place for children to play and make friends in the community. Hopefully, my ideas will be helpful to our club. Best regards, Mary.',
                    ],
                ],
            ],
            [
                'question' => 'Part 4: Technology Club - solve the problem of negative comments on the website.',
                'type' => 'viet4',
                'meta' => [
                    'intro_title' => 'Dear member,',
                    'intro_body' => 'Members often post on the club website. But lately there have been a few negative comments on other members posts. We are thinking of changing the website to identify anyone who makes a comment. Please give your opinion to fix the situation.',
                    'intro_signature' => 'Best, Club Manager.',
                    'task_1_instruction' => 'Write an email to your friend (about 50 words).',
                    'task_2_instruction' => 'Write an email to the manager with solutions for this problem (about 120-150 words).',
                ],
                'answers' => [
                    [
                        'position' => 1,
                        'content' => 'Hi Anna, I have just received an email from our Technology Club. Some members posted negative comments on others on the website. The club may identify people who comment. I think this is necessary and will make the online environment more respectful and friendly. Best, Mary.',
                    ],
                    [
                        'position' => 2,
                        'content' => 'Dear Manager, My name is Mary. I have been an active member of the club for the last six months. I am writing this email regarding the problem mentioned in the latest announcement. According to the email, our club is facing a situation where some members leave negative comments on other members posts on the website. To be honest, I was so worried as the problem can negatively affect the image of our club. Being a member of the club, I would like to offer some solutions. It is better for us to require members to log in with their real names before posting comments because this will make people more responsible for their words. I suggest we should set clear rules for online behavior and warn members who post rude comments. Hopefully, my ideas will be helpful to our club. Best regards, Mary.',
                    ],
                ],
            ],
            [
                'question' => 'Part 4: Art Club - suggest a speaker and topic for a public talk.',
                'type' => 'viet4',
                'meta' => [
                    'intro_title' => 'Dear all members,',
                    'intro_body' => 'The Art Club is organizing a talk to the public to attract more attention. We are going to invite an artist to give a talk to members. As a member of our club, could you suggest an artist and what topic should they share to gain more attention? We would like to have more both young and elderly members.',
                    'intro_signature' => 'Best, Club Organizer.',
                    'task_1_instruction' => 'Write an email to your friend, also a member of the club (about 50 words).',
                    'task_2_instruction' => 'Write an email to the organizer and suggest the speaker and topic (about 120-150 words).',
                ],
                'answers' => [
                    [
                        'position' => 1,
                        'content' => 'Hi Anna, I got the new email from our Art Club. They want to invite an artist to give a public talk. I think this is a great idea because we can learn more practical knowledge and attract more people to join our club activities. Best, Mary.',
                    ],
                    [
                        'position' => 2,
                        'content' => 'Dear Manager, My name is Mary. I have been an active member of the club for the last six months. I am writing this email regarding the upcoming event mentioned in the latest announcement from our club. According to the email, our club is organizing a talk to the public to attract more attention. To be honest, I was so excited to hear that because it will be a great opportunity for me to learn more about art. Being a member of the club, I would like to offer some ideas. It is better for us to invite a famous artist. I highly recommend Mr David as he has a lot of experience and expertise. He can share about the importance of art in daily life. This topic may attract both young and elderly members to join the talk and learn more about art. Hopefully, my ideas will be helpful to our club. Best regards, Mary.',
                    ],
                ],
            ],
            [
                'question' => 'Part 4: Computer Club - improve the website to attract more members.',
                'type' => 'viet4',
                'meta' => [
                    'intro_title' => 'Dear members,',
                    'intro_body' => 'We are making some changes to the website because we want more people to join us. As you know, the website at the moment is very simple and we would be interested to hear some ideas about ways to make it more attractive and why you think it would attract more visitors.',
                    'intro_signature' => 'Best, Club Manager.',
                    'task_1_instruction' => 'Write an email to your friend, who is also a member of this club. Tell your friend your opinion and why (about 50 words).',
                    'task_2_instruction' => 'Write an email to the manager of the club. Tell the manager your opinion and why (about 120-150 words).',
                ],
                'answers' => [
                    [
                        'position' => 1,
                        'content' => 'Hi Jane, I have just read the newest email from our Computer Club. I feel very excited because upgrading the website is a great idea. I think we should add activity photos and a clear join-us page, so visitors can understand the club and register quickly. See you, Mary.',
                    ],
                    [
                        'position' => 2,
                        'content' => 'Dear Manager, My name is Mary, and I have been an active member of the club for the past six months. I am writing in response to the recent announcement from our club. According to the email, our club is going to improve the website to attract more members. To be honest, I was absolutely delighted to hear this news because it will be a wonderful opportunity to promote our club image in the community. As a dedicated member, I would like to share some suggestions. It would be better for us to redesign the homepage with a modern layout, clear colors, and real photos from club activities. In addition, I suggest we should add a simple registration form and a section for members stories, so visitors can connect with our community more easily. I truly hope my ideas will be useful. Best regards, Mary.',
                    ],
                ],
            ],
            [
                'question' => 'Part 4: Charity Club - upcoming fundraising event next month.',
                'type' => 'viet4',
                'meta' => [
                    'intro_title' => 'Dear members,',
                    'intro_body' => 'Our club is going to organize a charity fundraising event next month. We hope to attract more members and supporters from the local community. Please send your ideas to make this event successful and meaningful.',
                    'intro_signature' => 'Best, Club Manager.',
                    'task_1_instruction' => 'Write an email to your friend and share your feelings and suggestion (about 50 words).',
                    'task_2_instruction' => 'Write an email to the manager and provide two practical suggestions (about 120-150 words).',
                ],
                'answers' => [
                    [
                        'position' => 1,
                        'content' => 'Hi Anna, I am very happy to hear that our Charity Club will hold a fundraising event next month. I think we should promote it on social media and invite local schools to join. That way, more people can support the event and donate. Best, Mary.',
                    ],
                    [
                        'position' => 2,
                        'content' => 'Dear Manager, My name is Mary, and I have been an active member of the club for the past six months. I am writing in response to the recent announcement from our club. As stated in the email, our club is going to organize a charity fundraising event next month. To be honest, I was absolutely delighted to hear this news because it will be a wonderful opportunity to attract more members and promote our club positive image in the community. As a dedicated member, I would like to share some suggestions. Since this is an important event, I believe we should prepare everything carefully in advance. It would be better for us to create a detailed plan of activities and volunteer tasks. In addition, I suggest we should promote the event on social media to reach a larger audience. I truly hope my ideas will be useful. Best regards, Mary.',
                    ],
                ],
            ],

        ];

        foreach ($items as $item) {
            $question = Question::firstOrCreate([
                'question' => $item['question'],
                'type' => $item['type'],
            ], [
                'meta' => $item['meta'] ?? null,
            ]);

            if (! empty($item['meta'])) {
                $question->meta = $item['meta'];
                $question->save();
            }

            if (is_array($item['answers'])) {
                $firstAnswer = $item['answers'][0] ?? null;

                if (is_array($firstAnswer) && array_key_exists('content', $firstAnswer)) {
                    foreach ($item['answers'] as $answerItem) {
                        $answerText = trim((string) ($answerItem['content'] ?? ''));
                        if ($answerText === '') {
                            continue;
                        }

                        Answer::firstOrCreate([
                            'question_id' => $question->id,
                            'user_id' => null,
                            'answer_position' => (int) ($answerItem['position'] ?? 0) ?: null,
                            'content' => $answerText,
                        ]);
                    }

                    continue;
                }

                $answers = array_filter(array_map('trim', $item['answers']));
            } else {
                $answers = array_filter(array_map('trim', explode('/', $item['answers'])));
            }

            foreach ($answers as $answerText) {
                Answer::firstOrCreate([
                    'question_id' => $question->id,
                    'user_id' => null,
                    'answer_position' => null,
                    'content' => $answerText,
                ]);
            }
        }
    }
}
