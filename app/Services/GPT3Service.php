<?php


namespace App\Services;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class GPT3Service
{
    /**
     * @var string
     */
    public string $baseURL = 'https://api.openai.com/v1/';

    /**
     * @var string
     */
    public string $engine;

    /**
     * @var string
     */
    private string $apiKey;

    /**
     * GPT3Service constructor.
     * @param string $apiKey
     */
    public function __construct(string $apiKey = '')
    {
        $this->engine = 'davinci';
        $this->apiKey = config('gpt3.api_key', $apiKey);
    }

    /**
     * Sets GPT-3 base url.
     *
     * @param string $url
     * @return $this
     */
    public function setBaseUrl(string $url): self
    {
        $this->baseURL = $url;
        return $this;
    }

    /**
     * Sets GPT-3 engine. Davinci by default.
     *
     * @param string $engine
     * @return $this
     */
    public function setEngine(string $engine): self
    {
        $this->engine = $engine;
        return $this;
    }

    /**
     * @param string $endpoint
     * @return string
     */
    public function createRequestUrl(string $endpoint) {

        $baseURL = Str::finish($this->baseURL, '/');

        return $baseURL . $endpoint;
    }

    /**
     * Request to Open AI server.
     *
     * @param string $endpoint
     * @param array $data
     * @return array|mixed
     */
    public function request(string $endpoint, array $data = [])
    {
        return Http::withToken($this->apiKey)
            ->post($this->createRequestUrl($endpoint), $data)
            ->json();
    }

    /**
     * Retrieve engines.
     *
     * @return array|mixed
     */
    public function engines()
    {
        return $this->request('engines');
    }

    /**
     * Retrieve a specific engine.
     *
     * @param string|null $engine
     * @return array|mixed
     */
    public function engine(?string $engine = null)
    {
        $engine = $engine ?? $this->engine;
        return $this->request("engines/$engine");
    }

    /**
     * Request completion.
     *
     * @param string $prompt
     * @param array $data
     * @return array|mixed
     */
    public function completion(string $prompt, array $data = [])
    {
        Arr::set($data, 'prompt', $prompt);
        return $this->request("engines/$this->engine/completions", $data);
    }

    /**
     * Semantic search.
     *
     * @param string $query
     * @param array $documents
     * @return array|mixed
     */
    public function search(string $query, array $documents)
    {
        $data = [
            'query' => $query,
            'documents' => $documents,
        ];
        return $this->request("engines/$this->engine/search", $data);
    }
}
