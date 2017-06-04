<?php
/**
 * Created by PhpStorm.
 * User: lisa
 * Date: 6/2/17
 * Time: 6:17 PM
 */

namespace Ace\Api;

use Illuminate\Support\Collection;
use Ace\Models\Components\GitHubEvent;

class GitHub extends ApiRequest
{
    /**
     * The config key where the github base URL is located
     * @var string
     */
    protected $configKey = 'github.url';

    /**
     * Set the current GitHub API version
     * @see https://developer.github.com/v3/#current-version
     *
     * @return $this
     */
    protected function setVersion()
    {
        $this->setOption( 'Accept', 'application/vnd.github.v3+json' );

        return $this;
    }

    /**
     * @return Collection
     */
    public function organizationEvents()
    {
        //https://api.github.com/orgs/ACEmulator/events

        $organization = config( 'api.github.organization' );
        $this->sprintEndpoint( '/orgs/%s/events', [ $organization ] );

        $results = $this->setVersion()->httpGet();
        $this->reset();

        $body = $results->getBody();

        $events = collect( [] );

        foreach ( $body as $eventData ) {
            $event = new GitHubEvent( $eventData[ 'id' ], $eventData );

            $events->put( $event->id, $event );
        }

        return $events->sortByDesc( 'createdAt' );
    }
}