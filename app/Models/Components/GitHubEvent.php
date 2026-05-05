<?php
/**
 * Created by PhpStorm.
 * User: lisa
 * Date: 6/3/17
 * Time: 12:39 PM
 */

namespace Ace\Models\Components;

use Parsedown;
use Carbon\Carbon;

class GitHubEvent
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var array
     */
    protected $actor;

    /**
     * @var array
     */
    protected $repo;

    /**
     * @var array
     */
    protected $payload;

    /**
     * @var Carbon
     */
    public $createdAt;

    /**
     * @var array
     */
    protected $org;

    /**
     * GitHubEvent constructor.
     *
     * @param       $id
     * @param array $eventData
     */
    public function __construct( $id, array $eventData = [] )
    {
        $this->id = $id;

        $this->importData( $eventData );
    }

    /**
     * @param array $data
     */
    protected function importData( array $data )
    {
        foreach ( $data as $key => $value ) {
            $camelCase = camel_case( $key );

            if ( $camelCase == 'createdAt' ) {
                $value = Carbon::parse( $value );
            }

            $this->{$camelCase} = $value;
        }
    }

    /**
     * Extract the branch name a commit happened in out of the head info
     *
     * @return string
     */
    protected function getBranchFromHead()
    {
        $ref = array_get( $this->payload, 'ref', '' );

        return str_replace( 'refs/heads/', '', $ref );
    }

    /**
     * Extract just the repo name out of the name passed in the event
     *
     * @return string
     */
    protected function getRepoFromOrg()
    {
        $orgAndRepo = array_get( $this->repo, 'name', '' );
        $org = array_get( $this->org, 'login', '' );

        return trim( str_replace( $org, '', $orgAndRepo ), '/' );
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Get the display name of the person who generated the event
     *
     * @return string
     */
    public function getUsername()
    {
        return array_get( $this->actor, 'display_login', '' );
    }

    /**
     * @return string
     */
    public function getLogin()
    {
        return array_get( $this->actor, 'login', '' );
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        switch ( $this->type ) {
            case 'PullRequestEvent':
                return array_get( $this->payload, 'pull_request.html_url', '#' );
            break;

            case 'IssueCommentEvent':
            case 'PullRequestReviewCommentEvent':
                return array_get( $this->payload, 'comment.html_url', '#' );
            break;

            case 'PushEvent':
                $head = array_get( $this->payload, 'head', '' );
                $repo = array_get( $this->repo, 'name', '' );

                return 'https://github.com/' . $repo . '/commit/' . $head;
            break;

            case 'IssuesEvent':
                return array_get( $this->payload, 'issue.html_url' );
            break;

            case 'ReleaseEvent':
                return array_get( $this->payload, 'release.html_url', '' );
            break;
        }

        return '#';
    }

    /**
     * @return string
     */
    public function getLinkText()
    {
        switch ( $this->type ) {
            case 'PullRequestEvent':
                $repo = array_get( $this->repo, 'name', '' );
                $number = array_get( $this->payload, 'number', 1 );
                $title = array_get( $this->payload, 'pull_request.title', '' );
                $action = array_get( $this->payload, 'action', '' );

                return '[' . $repo . '] Pull request ' . $action . ': #' . $number . ' ' . $title;
            break;

            case 'PullRequestReviewCommentEvent':
                $repo = array_get( $this->repo, 'name', '' );
                $prNumber = array_get( $this->payload, 'pull_request.number', 1 );
                $title = array_get( $this->payload, 'pull_request.title', '' );

                return '[' . $repo . '] Review comment added: #' . $prNumber . ' ' . $title;
            break;

            case 'IssueCommentEvent':
                $issueNumber = array_get( $this->payload, 'issue.number', 1 );

                return 'Comment added to issue #' . $issueNumber;
            break;

            case 'PushEvent':
                $repo = array_get( $this->repo, 'name', '' );
                $branch = $this->getBranchFromHead();

                $count = array_get( $this->payload, 'size', 0 );

                return '[' . $repo . ':' . $branch . '] ' . $count . ' new commit(s)';
            break;

            case 'IssuesEvent':
                $repo = array_get( $this->repo, 'name', '' );
                $issueNumber = array_get( $this->payload, 'issue.number', 1 );
                $title = array_get( $this->payload, 'issue.title', '' );
                $action = array_get( $this->payload, 'action' );

                return '[' . $repo . '] Issue ' . ucwords( $action ) . ': #' . $issueNumber . ' ' . $title;
            break;

            case 'ReleaseEvent':
                $repo = array_get( $this->repo, 'name', '' );
                $ref = array_get( $this->payload, 'release.tag_name', '' );

                return '[' . $repo . '] Release: ' . $ref;
            break;

        }

        return '';
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        $parsedown = new Parsedown();

        $description = '';
        switch ( $this->type ) {
            case 'DeleteEvent':
                $type = array_get( $this->payload, 'ref_type', '' );
                $reference = array_get( $this->payload, 'ref', '' );
                $user = array_get( $this->actor, 'login', '' );
                $description = $user . ' deleted the ' . $reference . ' ' . $type . '.';
            break;

            case 'IssueCommentEvent':
                $description = '<div class="markdown border rounded border-info">' . $parsedown->text( array_get( $this->payload, 'comment.body' ) ) . '</div>';
            break;

            case 'PullRequestEvent':
                $status = array_get( $this->payload, 'action', '' );

                if ( $status != 'closed' ) {
                    $description = '<div class="markdown border rounded border-info">' . $parsedown->text( array_get( $this->payload, 'pull_request.body', '' ) ) . '</div>';
                }
            break;

            case 'PullRequestReviewCommentEvent':
                $description = '<div class="markdown border rounded border-info">' . $parsedown->text( array_get( $this->payload, 'comment.body', '' ) ) . '</div>';
            break;

            case 'PushEvent':
                $texts = [];
                $commits = array_get( $this->payload, 'commits', [] );

                foreach ( $commits as $commit ) {
                    $hash = array_get( $commit, 'sha', '' );
                    $message = array_get( $commit, 'message', '' );
                    $text = substr( $hash, 0, 6 ) . ' - ' . $message;

                    $texts[] = $text;
                }

                $description = '<div class="markdown border rounded border-info">' . $parsedown->text( implode( '<br />', $texts ) ) . '</div>';
            break;

            case 'IssuesEvent':
                $description = '<div class="markdown border rounded border-info">' . $parsedown->text( array_get( $this->payload, 'issue.body', '' ) ) . '</div>';
            break;

            case 'ReleaseEvent':
                $description = '<div class="markdown border rounded border-info">' . $parsedown->text( array_get( $this->payload, 'release.body', '' ) ) . '</div>';
            break;
        }

        return '<div class="' . $this->type . '">' . $description . '</div>';
        //return str_replace( [ "\r\n", "\n" ], '<br />', $description );
    }
}
