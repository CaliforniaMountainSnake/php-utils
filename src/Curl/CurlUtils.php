<?php /** @noinspection CurlSslServerSpoofingInspection */

namespace CaliforniaMountainSnake\UtilTraits\Curl;

/**
 * A trait to work with http queries via CURL.
 */
trait CurlUtils
{
    use CurlHttpMethods;

    /**
     * @return array
     */
    protected function getDefaultCurlParams(): array
    {
        return [
            \CURLOPT_RETURNTRANSFER => 1,
            \CURLOPT_FOLLOWLOCATION => 1,
            \CURLOPT_SSL_VERIFYPEER => 0,
            \CURLOPT_SSL_VERIFYHOST => 0,
            \CURLOPT_CONNECTTIMEOUT => 10,
            \CURLOPT_TIMEOUT => 10,
        ];
    }

    /**
     * Execute any HTTP query.
     *
     * @param RequestMethodEnum $_method Request method.
     * @param string $_url Target URL.
     * @param array $_params [OPTIONAL] Request parameters.
     * @param array $_extra_options [OPTIONAL] Additional \CURLOPT_XXX options.
     *
     * @return HttpResponse
     */
    protected function httpQuery(
        RequestMethodEnum $_method,
        string $_url,
        array $_params = [],
        array $_extra_options = []
    ): HttpResponse {
        $ch      = \curl_init();
        $options = [
            \CURLOPT_CUSTOMREQUEST => (string)$_method,
        ];

        if ((string)$_method === RequestMethodEnum::GET) {
            $options[\CURLOPT_URL] = (empty($_params) ? $_url : $_url . '?' . \http_build_query($_params));
        } else {
            $options[\CURLOPT_URL]        = $_url;
            $options[\CURLOPT_POSTFIELDS] = $_params;
        }

        \curl_setopt_array($ch, $_extra_options + $options + $this->getDefaultCurlParams());

        $result = curl_exec($ch);
        $code   = \curl_getinfo($ch, \CURLINFO_HTTP_CODE);

        \curl_close($ch);
        return new HttpResponse($result, $code);
    }

    /**
     * Download a file via CURL.
     *
     * @param   string $_url Files's URL.
     * @param   string $_output_filename The name of the file to which the target file will be saved.
     *
     * @return  bool Is the file downloaded successfully?
     */
    protected function downloadFile(string $_url, string $_output_filename): bool
    {
        $ch      = \curl_init();
        $options = [
            \CURLOPT_URL => $_url,
        ];
        \curl_setopt_array($ch, $options + $this->getDefaultCurlParams());
        $result = \curl_exec($ch);

        $httpCode = \curl_getinfo($ch, \CURLINFO_HTTP_CODE);
        if ($httpCode !== 200) {
            \curl_close($ch);
            return false;
        }

        $fp = \fopen($_output_filename, 'wb');
        \fwrite($fp, $result);
        \fclose($fp);

        \curl_close($ch);
        return true;
    }
}
