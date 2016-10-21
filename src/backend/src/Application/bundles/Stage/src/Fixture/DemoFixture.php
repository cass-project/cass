<?php
namespace CASS\Application\Bundles\Stage\Fixture;

use CASS\Util\Definitions\Point;
use CASS\Util\GenerateRandomString;
use CASS\Domain\Bundles\Account\Entity\Account;
use CASS\Domain\Bundles\Account\Service\AccountService;
use CASS\Domain\Bundles\Attachment\Entity\Attachment;
use CASS\Domain\Bundles\Attachment\Repository\AttachmentRepository;
use CASS\Domain\Bundles\Attachment\Service\AttachmentService;
use CASS\Domain\Bundles\Auth\Service\CurrentAccountService;
use CASS\Domain\Bundles\Avatar\Parameters\UploadImageParameters;
use CASS\Domain\Bundles\Collection\Collection\CollectionItem;
use CASS\Domain\Bundles\Collection\Entity\Collection;
use CASS\Domain\Bundles\Collection\Service\CollectionService;
use CASS\Domain\Bundles\Post\Entity\Post;
use CASS\Domain\Bundles\Post\Parameters\CreatePostParameters;
use CASS\Domain\Bundles\Post\PostType\Types\DefaultPostType;
use CASS\Domain\Bundles\Post\Service\PostService;
use CASS\Domain\Bundles\Profile\Entity\Profile;
use CASS\Domain\Bundles\Profile\Entity\Profile\Gender\Gender;
use CASS\Domain\Bundles\Profile\Parameters\EditPersonalParameters;
use CASS\Domain\Bundles\Profile\Service\ProfileService;
use CASS\Util\Seek;
use Cocur\Chain\Chain;
use Symfony\Component\Console\Output\OutputInterface;

final class DemoFixture
{
    const JSON_DIR = __DIR__.'/../Resources/Data/JSON';
    const AVATAR_DIR = __DIR__ . "/../Resources/Data/Images/avatars/";

    /** @var AccountService */
    protected $accountService;

    /** @var ProfileService */
    protected $profileService;

    /** @var CollectionService */
    protected $collectionService;

    /** @var PostService */
    protected $postService;

    /** @var AttachmentService */
    protected $attachmentService;

    /** @var AttachmentRepository */
    protected $attachmentRepository;

    /** @var CurrentAccountService */
    private $currentAccountService;

    /** @var array */
    private $jsonProfiles;

    /** @var array */
    private $jsonFeed;

    /** @var  @var array */
    private $jsonVideos;

    /** @var OutputInterface */
    private $output;

    /** @var Profile[] */
    private $profilesMap = [];

    public function __construct(
        AccountService $accountService,
        CurrentAccountService $currentAccountService,
        ProfileService $profileService,
        CollectionService $collectionService,
        PostService $postService,
        AttachmentService $attachmentService,
        AttachmentRepository $attachmentRepository
    ) {
        $this->accountService = $accountService;
        $this->currentAccountService = $currentAccountService;
        $this->profileService = $profileService;
        $this->collectionService = $collectionService;
        $this->postService = $postService;
        $this->attachmentService = $attachmentService;
        $this->attachmentRepository = $attachmentRepository;
    }

    public function up(OutputInterface $output)
    {
        $this->output = $output;

        $this->fetchJSONSources();

        $this->upAccountsFixture();
        $this->upFeedFixture();
        $this->syncFeedFixture();
    }

    public function sync(OutputInterface $output)
    {
        $this->output = $output;

        $this->profileService->disableAutoImageGeneration();

        $this->fetchJSONSources();
        $this->syncFeedFixture();
    }

    private function upAccountsFixture()
    {
        $this->output->writeln(['', '[ACCOUNT/PROFILE FIXTURE]', '']);

        $counter = 0;

        foreach($this->jsonProfiles as $json) {
            ++$counter;

            $account = $this->createAccountFromJSON($json);
            $profile = $account->getCurrentProfile();

            $progress = round((100/count($this->jsonProfiles)) * $counter);

            $this->output->writeln(sprintf(' [*] [%s%%] Account: [ID: %d, origID: %d]', $progress, $account->getId(), $json['id']));
            $this->output->writeln(sprintf('            Profile: [ID: %d] %s', $profile->getId(), $profile->getGreetings()->__toString()));

            $this->profilesMap[(int) $json['profile_id']] = $profile;
        }
    }

    private function upFeedFixture()
    {
        $this->output->writeln(['', '[FEED FIXTURE]', '']);

        usort($this->jsonFeed, function($a, $b) {
            return \DateTime::createFromFormat('Y-m-d H:i:s', $a['createdOn']) > \DateTime::createFromFormat('Y-m-d H:i:s', $b['createdOn']);
        });

        foreach($this->jsonFeed as $json) {
            $profile = $this->profilesMap[$json['author_id']] ?? false;

            if($profile) {
                $this->output->writeln(sprintf(' [*] Post (date: %s, origID: %d)', $json['createdOn'], $json['id']));

                $item = $profile->getCollections()->getItems()[0]; /** @var CollectionItem $item */
                $collection = $this->collectionService->getCollectionById($item->getCollectionId());

                $this->createPost($profile, $collection, $json);
            }
        }
    }

    private function fetchJSONSources()
    {
        $this->jsonProfiles = $this->fetchJSON(self::JSON_DIR.'/profile.json');
        $this->jsonFeed = $this->fetchJSONGlob(self::JSON_DIR.'/feed_*.json');
        $this->jsonVideos = $this->fetchJSON(self::JSON_DIR.'/video.json');
    }

    private function fetchJSON(string $path): array
    {
        $this->output->writeln(sprintf('[*] Fetch JSON: %s', $path));

        if(! ($source = file_get_contents($path))) {
            throw new \Exception(sprintf('Failed to read JSON file `%s`', $path));
        }

        if (0 === strpos(bin2hex($source), 'efbbbf')) {
            $source = substr($source, 3);
        }

        $result = json_decode($source, true);

        if($result === null) {
            throw new \Exception(sprintf('Failed to parse JSON(%s) : %s', $path, json_last_error_msg()));
        }

        return $result;
    }

    private function fetchJSONGlob(string $pattern): array
    {
        $result = [];

        $this->output->writeln(sprintf('[***] Fetch JSON (glob): %s', $pattern));

        array_map(function(string $path) use(&$result) {
            foreach($this->fetchJSON($path) as $entity) {
                $result[] = $entity;
            }
        }, glob($pattern));

        return $result;
    }

    private function createAccountFromJSON(array $json): Account
    {
        if($this->accountService->hasAccountWithEmail($json['email'])) {
            return $this->accountService->getByEmail($json['email']);
        }else{
            $account = $this->accountService->createAccount($json['email'], GenerateRandomString::gen(12));
            $profile = $account->getCurrentProfile();

            $profile->setGender(Gender::createFromIntCode((int) $json['gender']));

            $parameters = new EditPersonalParameters(
                'fl',
                false,
                $json['username'] ?? '',
                $json['surname'] ?? '',
                $json['patronymic'] ?? '',
                $json['nickname'] ?? ''
            );

            $this->profileService->updatePersonalData($profile->getId(), $parameters);
            $this->profileService->setInterestingInThemes($profile->getId(), $json['interests']);

            if($json['birthday']) {
                $this->profileService->setBirthday($profile->getId(), \DateTime::createFromFormat('Y-m-d', $json['birthday']));
            }

            $avatarPath = sprintf("%s/%s", self::AVATAR_DIR, $json['avatar']);

            if(file_exists($avatarPath)) {
                list($width, $height) = getimagesize($avatarPath);

                if(! is_null($width) && ! is_null($height)) {
                    $size = min($width, $height);
                    $parameters = new UploadImageParameters($avatarPath, new Point(0, 0), new Point($size, $size));

                    $this->profileService->uploadImage($profile->getId(), $parameters);
                }
            }else{
                $this->profileService->generateProfileImage($profile->getId());
            }

            return $account;
        }
    }

    private function createPost(Profile $profile, Collection $collection, array $json): Post
    {
        $this->output->writeln(sprintf(' [*] - Create post (id: %s)', $json['id']));

        $parameters = $this->createPostParameters($profile, $collection, $json);

        $this->collectionService->editThemeIds($collection->getId(), $json['themeIds']);
        $post = $this->postService->createPost($parameters);
        $post = $this->postService->replaceDateCreatedOn($post->getId(), \DateTime::createFromFormat('Y-m-d H:i:s', $json['createdOn']));
        $this->collectionService->editThemeIds($collection->getId(), []);

        return $post;
    }

    private function createPostParameters(Profile $profile, Collection $collection, array $json): CreatePostParameters
    {
        switch((int) $json['typeId']) {
            default:
                throw new \Exception(sprintf('Unknown type_id `%s`', $json['type_id']));

            case 0: // "content", simple post
                return new CreatePostParameters(
                    DefaultPostType::CODE_INT,
                    $profile->getId(),
                    $collection->getId(),
                    $json['title'] ?? '',
                    $json['description'] ?? '',
                    []
                );

            case 2: // youtube
                $url = $json['url'];
                $parsedURL = parse_url($url);

                if(! isset($parsedURL['host'])) {
                    $url = 'https://www.youtube.com/watch?v=yKBLCcQObdQ';
                    $v = 'yKBLCcQObdQ';
                }else{
                    if((strtolower($parsedURL['host']) === 'youtu.be') || (! isset($parsedURL['query']))) {
                        $v = str_replace('/', '', $parsedURL['path']);
                    }else{
                        $params = [];
                        parse_str(parse_url($url)['query'] ?? '', $params);

                        $v = $params['v'];
                    }
                }

                $linkAttachment = new Attachment($json['title'] ?? '', $json['description'] ?? '');
                $linkAttachment->setMetadata([
                   'url' => $url,
                   'resource' => 'youtube',
                   'source' => [
                       'source' => 'external',
                       'origURL' => $url,
                   ],
                   'metadata' => [
                       'og' => [
                           'basic' => [
                               'description' => '',
                               'title' => '',
                               'url' => $url,
                           ],
                           'og' => [
                               'basic' => [
                                   'og:url' => $url,
                                   'og:title' => '',
                                   'og:type' => '',
                                   'og:description' => '',
                                   'og:determiner' => '',
                                   'og:locale' => '',
                                   'og:locale:alternate' => '',
                                   'og:site_name' => '',
                               ],
                               'images' => [[
                                                'og:image' => '',
                                                'og:image:url' => '',
                                                'og:image:type' => '',
                                                'og:image:width' => '',
                                                'og:image:height' => '',
                                            ]],
                               'videos' => [[
                                                'og:video' => '',
                                                'og:video:url' => '',
                                                'og:video:type' => '',
                                                'og:video:width' => '',
                                                'og:video:height' => '',
                                            ]],
                               'audios' => [[
                                                'og:video' => '',
                                                'og:video:url' => '',
                                                'og:video:type' => '',
                                            ]]
                           ]
                       ],
                       'youtubeId' => $v,
                   ]
               ]);

                $this->attachmentRepository->createAttachment($linkAttachment);

                return new CreatePostParameters(
                    DefaultPostType::CODE_INT,
                    $profile->getId(),
                    $collection->getId(),
                    $json['title'] ?? '',
                    $json['description'] ?? '',
                    [$linkAttachment->getId()]
                );

            case 3: // link
                $options = json_decode($json['options'], true);

                $url =  $options['url'];
                $params = [];

                parse_str(parse_url($url)['query'] ?? '', $params);

                $title = $options['title'] ?? '';
                $description =  $options['description'] ?? '';
                $image = $options['image'] ?? '';

                $linkAttachment = new Attachment($title, $description);
                $linkAttachment->setMetadata([
                   'url' => $url,
                   'resource' => 'page',
                   'source' => [
                       'source' => 'external',
                       'origURL' => $url,
                   ],
                   'metadata' => [
                       'og' => [
                           'basic' => [
                               'description' => $description,
                               'title' => $title,
                               'url' => $url,
                           ],
                           'og' => [
                               'basic' => [
                                   'og:url' => $url,
                                   'og:title' => $title,
                                   'og:type' => '',
                                   'og:description' => $description,
                                   'og:determiner' => '',
                                   'og:locale' => '',
                                   'og:locale:alternate' => '',
                                   'og:site_name' => '',
                               ],
                               'images' => [[
                                                'og:image' => $image,
                                                'og:image:url' => $image,
                                                'og:image:type' => '',
                                                'og:image:width' => '',
                                                'og:image:height' => '',
                                            ]],
                               'videos' => [[
                                                'og:video' => '',
                                                'og:video:url' => '',
                                                'og:video:type' => '',
                                                'og:video:width' => '',
                                                'og:video:height' => '',
                                            ]],
                               'audios' => [[
                                                'og:video' => '',
                                                'og:video:url' => '',
                                                'og:video:type' => '',
                                            ]]
                           ]
                       ],
                   ]
               ]);

                $this->attachmentRepository->createAttachment($linkAttachment);

                return new CreatePostParameters(
                    DefaultPostType::CODE_INT,
                    $profile->getId(),
                    $collection->getId(),
                    $json['title'] ?? '',
                    $json['description'] ?? '',
                    [$linkAttachment->getId()]
                );
        }
    }

    private function syncFeedFixture()
    {
        $step = 200;
        $offset = 0;
        $limit = $step;

        $this->output->writeln('[*] Creating link&youtube videos map');

        $linkMap = Chain::create($this->jsonFeed)
            ->filter(function($input) {
                return (int) $input["typeId"] === 2 || (int) $input["typeId"] === 3;
            })
            ->map(function($input) {
                if(isset($input['video_title'])) {
                    return [
                        'meta' => [
                            'title' => $input['video_title'] ?? '',
                            'description' => $input['video_description'] ?? '',
                        ],
                        'url' => $input['url']
                    ];
                }else if(isset($input['options']) && strlen(isset($input['options']))) {
                    $option = $input['options'];

                    if(is_string($option)) {
                        $option = json_decode($input['options'], true);
                    }

                    if(is_array($option) && count(array_keys($option))) {
                        return [
                            'meta' => [
                                'title' => $option['title'] ?? '',
                                'description' => $option['description'] ?? '',
                            ],
                            'url' => $option['url']
                        ];
                    }else{
                        return [
                            'meta' => [
                                'title' => $input['title'] ?? '',
                                'description' => $input['description'] ?? '',
                            ],
                            'url' => $input['url']
                        ];
                    }

                }else{
                    return [
                        'meta' => [
                            'title' => $input['title'] ?? '',
                            'description' => $input['description'] ?? '',
                        ],
                        'url' => $input['url']
                    ];
                }
            })
            ->array;

        foreach($this->jsonVideos as $video) {
            $linkMap[] = [
                'meta' => [
                    'title' => $video['name'],
                    'description' => ''
                ],
                'url' => $video['url']
            ];
        }

        $linkMap = array_combine(
            array_column($linkMap, 'url'),
            array_column($linkMap, 'meta')
        );

        $specified = 0;

        while(count($result = $this->attachmentRepository->listAttachments(new Seek($step, $offset, $limit)))) {
            $this->output->writeln(sprintf('[*] Fetch attachments (%d - %d)', $offset, $offset+$step));

            array_map(function(Attachment $attachment) use($linkMap, &$specified)  {
                $url =  $attachment->getMetadata()['url'];

                if(isset($linkMap[$url])) {
                    $title = $linkMap[$url]['title'];
                    $description = $linkMap[$url]['description'];

                    $percent = round(100/count($linkMap) * $specified, 2);

                    $this->output->writeln(sprintf('[*] [%s%%] Specify link("%s"), metadata("%s", "%s")', $percent, $url, $title, $description));

                    $this->attachmentService->specifyTitleAndDescriptionFor($attachment, $title, $description);

                    ++$specified;
                }
            }, $result);

            $offset += $step;
        }

        var_dump($specified);
    }
}