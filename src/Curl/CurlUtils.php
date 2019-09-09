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
     * Warning! All queries have "application/x-www-form-urlencoded" encoding.
     * Only POST query have "multipart/form-data" encoding if it has files.
     *
     * @param RequestMethodEnum $_method        Request method.
     * @param string            $_url           Target URL.
     * @param array             $_params        [OPTIONAL] Request parameters.
     * @param array             $_extra_options [OPTIONAL] Additional \CURLOPT_XXX options.
     *
     * @return HttpResponse
     */
    protected function httpQuery(
        RequestMethodEnum $_method,
        string $_url,
        array $_params = [],
        array $_extra_options = []
    ): HttpResponse {
        $method = (string)$_method;
        $ch = \curl_init();
        $options = [
            \CURLOPT_CUSTOMREQUEST => $method,
            \CURLOPT_URL => $_url,
        ];

        if ($method === RequestMethodEnum::GET) {
            // Just GET.
            $options[\CURLOPT_URL] = (empty($_params) ? $_url : $_url . '?' . \http_build_query($_params));
        } elseif ($method === RequestMethodEnum::POST) {
            // Encoding files.
            $options[\CURLOPT_POSTFIELDS] = $this->build_post_fields($_params);
        } else {
            // Simple form-encoded.
            $options[\CURLOPT_POSTFIELDS] = \http_build_query($_params);
        }


        \curl_setopt_array($ch, $_extra_options + $options + $this->getDefaultCurlParams());

        $result = curl_exec($ch);
        $code = \curl_getinfo($ch, \CURLINFO_HTTP_CODE);

        \curl_close($ch);
        return new HttpResponse($result, $code);
    }

    /**
     * Download a file via CURL.
     *
     * @param   string $_url             Files's URL.
     * @param   string $_output_filename The name of the file to which the target file will be saved.
     *
     * @return  bool Did the file download successfully?
     */
    protected function downloadFile(string $_url, string $_output_filename): bool
    {
        $ch = \curl_init();
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

    /**
     * Use this to send data with multidimensional arrays and CURLFiles
     *  `curl_setopt($ch, CURLOPT_POSTFIELDS, build_post_fields($postfields));`
     *
     * @param        $_data
     * @param string $_existing_keys - will set the paramater name, probably don't want to use
     * @param array  $_return_array  - Can pass data to start with, only put good data here
     *
     * @return array
     *
     * @author Yisrael Dov Lebow <lebow@lebowtech.com>
     * @see    https://gist.github.com/yisraeldov/ec29d520062575c204be7ab71d3ecd2f
     * @see    https://stackoverflow.com/questions/3453353/how-to-upload-files-multipart-form-data-with-multidimensional-postfields-using
     * @see    http://stackoverflow.com/questions/35000754/array-2-string-conversion-while-using-curlopt-postfields/35002423#comment69460359_35002423
     */
    protected function build_post_fields($_data, $_existing_keys = '', &$_return_array = []): array
    {
        if (($_data instanceof \CURLFile) || !(\is_array($_data) || \is_object($_data))) {
            $_return_array[$_existing_keys] = $_data;
            return $_return_array;
        }

        foreach ($_data as $key => $item) {
            $existingKeys = $_existing_keys ? $_existing_keys . "[$key]" : $key;
            $this->build_post_fields($item, $existingKeys, $_return_array);
        }
        return $_return_array;
    }
}
