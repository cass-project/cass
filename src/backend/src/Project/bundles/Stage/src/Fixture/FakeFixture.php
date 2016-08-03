<?php
namespace CASS\Project\Bundles\Stage\Fixture;

use Application\Util\Definitions\Point;
use Application\Util\GenerateRandomString;
use Domain\Account\Entity\Account;
use Domain\Account\Service\AccountService;
use Domain\Auth\Service\CurrentAccountService;
use Domain\Avatar\Parameters\UploadImageParameters;
use Domain\Collection\Collection\CollectionItem;
use Domain\Collection\Entity\Collection;
use Domain\Collection\Parameters\EditCollectionParameters;
use Domain\Collection\Service\CollectionService;
use Domain\Post\Entity\Post;
use Domain\Post\Parameters\CreatePostParameters;
use Domain\Post\PostType\Types\DefaultPostType;
use Domain\Post\Service\PostService;
use Domain\PostAttachment\Entity\PostAttachment;
use Domain\PostAttachment\Repository\PostAttachmentRepository;
use Domain\PostAttachment\Service\PostAttachmentService;
use Domain\Profile\Entity\Profile;
use Domain\Profile\Entity\Profile\Gender\Gender;
use Domain\Profile\Middleware\Parameters\EditPersonalParameters;
use Domain\Profile\Service\ProfileService;
use Symfony\Component\Console\Output\OutputInterface;

final class FakeFixture
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

    /** @var PostAttachmentService */
    protected $postAttachmentService;

    /** @var PostAttachmentRepository */
    protected $postAttachmentRepository;

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

    /** @var Account[] */
    private $accountsMap;

    public function __construct(
        AccountService $accountService,
        CurrentAccountService $currentAccountService,
        ProfileService $profileService,
        CollectionService $collectionService,
        PostService $postService,
        PostAttachmentService $postAttachmentService,
        PostAttachmentRepository $postAttachmentRepository
    ) {
        $this->accountService = $accountService;
        $this->currentAccountService = $currentAccountService;
        $this->profileService = $profileService;
        $this->collectionService = $collectionService;
        $this->postService = $postService;
        $this->postAttachmentService = $postAttachmentService;
        $this->postAttachmentRepository = $postAttachmentRepository;
    }

    public function up(OutputInterface $output)
    {
        $this->output = $output;

        $this->fetchJSONSources();
        $this->upAccountsFixture();
        $this->upVideosFixture();
    }

    private function upAccountsFixture()
    {
        $counter = 0;

        foreach($this->jsonProfiles as $json) {
            ++$counter;

            $account = $this->createAccountFromJSON($json);
            $profile = $account->getCurrentProfile();

            $progress = round((100/count($this->jsonProfiles)) * $counter);

            $this->output->writeln(sprintf('[%s%%] Account: [ID: %d]', $progress, $account->getId()));
            $this->output->writeln(sprintf(' [*] Profile: [ID: %d] %s', $profile->getId(), $profile->getGreetings()->__toString()));

            $this->upProfileFeedFixture((int) $json['profile_id'], $account);
        }
    }

    private function upProfileFeedFixture(int $fakeProfileId, Account $account)
    {
        $this->output->writeln(' [*] Post fixtures');

        $posts = array_filter($this->jsonFeed, function($input) use ($fakeProfileId) {
            return ((int) $input['author_id']) === $fakeProfileId;
        });

        array_map(function(array $jsonPost) use ($account) {
            /** @var CollectionItem $collectionItem */
            $collectionItem = $account->getCurrentProfile()->getCollections()->getItems()[0];
            $collection = $this->collectionService->getCollectionById($collectionItem->getCollectionId());

            $profile = $account->getCurrentProfile();
            $profile->setInterestingInIds(array_merge($profile->getInterestingInIds(),[$jsonPost['category_id']]));
            $this->profileService->saveProfile($profile);

            $post = $this->createPost($account->getCurrentProfile(), $collection, $jsonPost);
        }, $posts);
    }

    private function fetchJSONSources()
    {
        $this->jsonProfiles = $this->fetchJSON(self::JSON_DIR.'/profiles.json');
        $this->jsonFeed = $this->fetchJSON(self::JSON_DIR.'/feed.json');
        $this->jsonVideos = $this->fetchJSON(self::JSON_DIR.'/video.json');
    }

    private function fetchJSON(string $path): array
    {
        $this->output->writeln(sprintf('Fetch JSON: %s', $path));

        if(! ($source = file_get_contents($path))) {
            throw new \Exception(sprintf('Failed to read JSON file `%s`', $path));
        }

        return json_decode($source, true);
    }

    private function createAccountFromJSON(array $json): Account
    {
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

        $avatarPath = sprintf("%s/%s", self::AVATAR_DIR, $json['avatar']);

        if(file_exists($avatarPath)) {
            list($width, $height) = getimagesize($avatarPath);

            if(! is_null($width) && ! is_null($height)) {
                $size = min($width, $height);
                $parameters = new UploadImageParameters($avatarPath, new Point(0, 0), new Point($size, $size));

                $this->profileService->uploadImage($profile->getId(), $parameters);
            }
        }

        $this->accountsMap[(int) $json['profile_id']] = $account;

        return $account;
    }

    private function createPost(Profile $profile, Collection $collection, array $json): Post
    {
        $this->output->writeln(sprintf(' [*] - Create post (id: %s)', $json['id']));

        $parameters = $this->createPostParameters($profile, $collection, $json);

        return $this->postService->createPost($parameters);
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
                    $json['description'],
                    []
                );

            case 2: // youtube
                $url = $json['url'];
                $parsedURL = parse_url($url);

                if((strtolower($parsedURL['host']) === 'youtu.be') || (! isset($parsedURL['query']))) {
                    $v = str_replace('/', '', $parsedURL['path']);
                }else{
                    $params = [];
                    parse_str(parse_url($url)['query'] ?? '', $params);

                    $v = $params['v'];
                }

                $linkAttachment = new PostAttachment();
                $linkAttachment->setAttachment([
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

                $this->postAttachmentRepository->createPostAttachment($linkAttachment);

                return new CreatePostParameters(
                    DefaultPostType::CODE_INT,
                    $profile->getId(),
                    $collection->getId(),
                    $json['description'] ?? '',
                    [$linkAttachment->getId()]
                );

            case 3: // link
                $url = $json['url'];
                $params = [];

                parse_str(parse_url($url)['query'] ?? '', $params);

                $title = $json['options']['title'] ?? '';
                $description = $json['options']['description'] ?? '';
                $image = $json['options']['image'] ?? '';

                $images = strlen($image)
                    ? [[
                           'og:image' => $image,
                           'og:image:url' => $image,
                       ]]
                    : [[
                           'og:image' => '',
                           'og:image:url' => '',
                       ]];

                $linkAttachment = new PostAttachment();
                $linkAttachment->setAttachment([
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
                   ]
               ]);

                $this->postAttachmentRepository->createPostAttachment($linkAttachment);

                return new CreatePostParameters(
                    DefaultPostType::CODE_INT,
                    $profile->getId(),
                    $collection->getId(),
                    $json['description'] ?? '',
                    [$linkAttachment->getId()]
                );
        }
    }

    private function upVideosFixture() {

        $averageVideos = ceil(count($this->jsonVideos)/count($this->accountsMap));

        $videoIdx = 1;
        $account = $this->accountsMap[array_rand($this->accountsMap )];

        foreach($this->jsonVideos as $video){
            if(0 === ($videoIdx % $averageVideos)) {
                $account = $this->accountsMap[array_rand($this->accountsMap )] ;
            }

            $this->currentAccountService->forceSignIn($account);

            /** @var Profile $profile */
            $profile = $account->getProfiles()->first();

            /** @var CollectionItem  $collectionItem */
            $collectionItem = $profile->getCollections()->getItems()[0];
            $collection = $this->collectionService->getCollectionById($collectionItem->getCollectionId());

            $collectionParams = new EditCollectionParameters(
                $collection->getTitle(),
                $collection->getDescription(),
                [$video['category_id']]
            );

            $collection = $this->collectionService->editCollection($collection->getId(), $collectionParams);

            $video['id']          = $videoIdx;
            $video['typeId']      = 2;
            $video['description'] = $video['name'];

            $profile->setInterestingInIds(array_merge($profile->getInterestingInIds(),[$video['category_id']]));
            $this->profileService->saveProfile($profile);

            $post = $this->createPost($account->getCurrentProfile(), $collection, $video);

            $videoIdx++;
        }
    }
}