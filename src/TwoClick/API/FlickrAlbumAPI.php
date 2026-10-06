<?php

namespace Drupal\grid\TwoClick\API;

use Drupal\grid\TwoClick\Constants\Constants;
use Drupal\grid\TwoClick\Constants\EmbedProperties;

class FlickrAlbumAPI extends ProviderAPIBase implements ProviderAPIInterface
{

  public function getEmbedProperties(string $url): EmbedProperties
  {

    $parsedUrl = parse_url($url);
    $path = $parsedUrl['path'];

    $explodedPath = explode('/albums/', $path);
    $firstPath = $explodedPath[0];
    $albumID =explode('/', $explodedPath[1])[0];

    $url = "https://www.flickr.com$firstPath/albums/$albumID";

    $flickrOembedUrl = "https://www.flickr.com/services/oembed/?format=json&url=$url";

    $request     = curl_init( $flickrOembedUrl );

    curl_setopt( $request, CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $request, CURLOPT_HEADER, false );
    $result = curl_exec( $request );
    curl_close( $request );
    $result           = json_decode( $result );

    $embedProperties = new EmbedProperties();
    if(is_null($result)) return $embedProperties;


    $this->embedCode = $result->html;

    $properties = [
      'title'          => t($result->title ?? ""),
      'author'         => $result->author_name ?? "",
      'url'            => $url,
      'urlDescription' => t("Watch on @provider", ['@provider' => 'Flickr']),
      'embed'          => $this->embedCode,
      'thumbnail'      => $result->thumbnail_url,
      'provider'       => 'Flickr'
    ];

    foreach ($properties as $propertyName => $propertyValue){
      $embedProperties->set($propertyName, $propertyValue);
    }

    return $embedProperties;
  }

  public function getThumbnail(string $url): string
  {
    return '';
  }
}
