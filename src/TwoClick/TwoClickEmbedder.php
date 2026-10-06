<?php

namespace Drupal\grid\TwoClick;

use Drupal\Core\File\FileSystemInterface;
use Drupal\grid\TwoClick\API\FlickrAlbumAPI;
use Drupal\grid\TwoClick\API\SpotifyAPI;
use Drupal\grid\TwoClick\API\VimeoAPI;
use Drupal\grid\TwoClick\API\YouTubeAPI;
use Drupal\grid\TwoClick\API\DefaultProvider;
use Drupal\grid\TwoClick\Constants\Constants;

class TwoClickEmbedder {
  private $folderPath;
  private $api;
  private string $customEmbedCode = '';

  public function __construct($folderPath){
    \Drupal::service( 'file_system' )->prepareDirectory( $folderPath, FileSystemInterface::CREATE_DIRECTORY | FileSystemInterface::MODIFY_PERMISSIONS );
    $this->folderPath = $folderPath;
    $this->api = new DefaultProvider($folderPath);
  }

  public function getProvider( $url ) {

    $this->api = new DefaultProvider($this->folderPath);
    if ($url === '') return Constants::PROVIDER_DEFAULT;

    $result = parse_url( $url );

    $host = strtolower( $result['host'] ?? '' );

    if ( $this->hostIs( $host, array( 'youtube.com', 'youtube-nocookie.com', 'youtu.be' ) ) ) {
      $this->api = new YouTubeAPI( $this->folderPath );
      return Constants::PROVIDER_YOUTUBE;
    }

    if ( $this->hostIs( $host, array( 'vimeo.com' ) ) ) {
      $this->api = new VimeoAPI( $this->folderPath );
      return Constants::PROVIDER_VIMEO;
    }

    if ( $this->hostIs( $host, array( 'podigee.io', 'podigee.com' ) ) ) {
    //  $this->api = new PodigeeAPI( $this->folderPath );
    //  return Constants::PROVIDER_PODIGEE;
      return false;
    }

    if ( $this->hostIs( $host, array( 'spotify.com' ) ) ) {
      $this->api = new SpotifyAPI( $this->folderPath );
      return Constants::PROVIDER_SPOTIFY;
    }


    if ( $this->hostIs( $host, array( 'flickr.com' ) ) ) {
      if (str_contains( $result['path'] ?? '', 'albums' )) {
        $this->api = new FlickrAlbumAPI( $this->folderPath );
        return Constants::PROVIDER_FLICKR;
      }

    }

    return Constants::PROVIDER_DEFAULT;
  }

  public function setEmbedCode(string $embedCode): void {
    $this->customEmbedCode = $embedCode;
    $this->api->setEmbedCode($embedCode);
  }


  public function switchIFrame( $url, $originalData = [] ) {

    $url = trim($url);

    $provider = $this->getProvider($url);

    if ($this->customEmbedCode !== '') $this->api->setEmbedCode($this->customEmbedCode);

    $embedProperties = $this->api->getEmbedProperties( $url );

    $originalData['embedProperties'] = $embedProperties;
    $originalData['code'] = $this->api->generateHTML( $embedProperties );

    return $originalData;

  }



  /**
   * The host is one of the domains or a subdomain of one: www.youtube.com, but
   * not youtube.example.org.
   *
   * @param string $host
   * @param string[] $domains
   *
   * @return bool
   */
  private function hostIs( string $host, array $domains ): bool {
    foreach ( $domains as $domain ) {
      if ( $host === $domain || str_ends_with( $host, '.' . $domain ) ) {
        return true;
      }
    }
    return false;
  }
}
