<?php

namespace App\Http\Controllers;

use Google\Client;
use Google\Service\Docs;
use Google\Service\Drive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\documents_id;
use Illuminate\Support\Facades\Http;
use App\Models\User;

class GoogleDocsController extends Controller
{

    public function view($documentId)
    {
        return view('notes', ['id' => $documentId]);
    }

    public function explainAddDoc()
    {
        return view('explain_add_doc');
    }

    public function index()
    {
        $data = documents_id::all();

        return view('docs_index', ['data' => $data]);
    }

    public function viewAddDocs()
    {
        return view('add_docs');
    }

    function getGoogleDocName()
    {
        $user = Auth::user();
        // Instantiate the Google API client
        $client = new Client();
        $client->setAuthConfig(public_path('google_docs_client_secret.json'));
        $client->setAccessToken($user->access_token);

        // Create a Google Docs service instance
        $service = new Docs($client);

        // Example: Retrieve document content
        $documentId = '1qdVixV5PyxyPaunfIwEgaetT4VYbcvDYIhS6j8yc1ew';
        $response = $service->documents->get($documentId);
        $docName = $response->getTitle();

        return $docName;
    }

    function storeGoogleDoc(Request $request)
    {

        try {
            $doclink = $request->input('input');

            preg_match('/\/document\/d\/([a-zA-Z0-9-_]+)\//', $doclink, $matches);

            if (isset($matches[1])) {
                $documentId = $matches[1];
            } else {
                throw new \Exception('Invalid Google Docs URL');
            }

            // Your further code logic goes here

        } catch (\Exception $e) {
            return response()->json(['error' => 'Invalid URL']);
        }
        $documentId = $matches[1];
        $user = Auth::user();
        $userName = $user->name;
        $refreshToken = $user->refresh_token;
        // Instantiate the Google API client
        $client = new Client();

        $client->setClientId(env('GOOGLE_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
        $client->setRedirectUri(env('GOOGLE_REDIRECT_URI'));
        $client->setAccessType('offline');

        $response = Http::post('https://oauth2.googleapis.com/token', [
            'grant_type' => 'refresh_token',
            'refresh_token' => $refreshToken,
            'client_id' => env('GOOGLE_CLIENT_ID'),
            'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        ]);

        $data = $response->json();

        if (isset($data['access_token'])) {
            // The new access token is in $data['access_token']
            $newAccessToken = $data['access_token'];
            $existingUser = User::where('email', $user->email)->first();

            if ($existingUser) {
                $existingUser->update([
                    'access_token' => $newAccessToken,
                ]);
            }
        } else {
            // Handle the error, e.g., log or redirect the user to re-authenticate
            if (isset($data['error_description'])) {
                $errorDescription = $data['error_description'];
                // Log or display the error description
                return $errorDescription;
            }
        }

        $client->setAuthConfig(public_path('google_docs_client_secret.json'));
        $client->setAccessToken($user->access_token);

        // Create a Google Docs service instance
        $service = new Docs($client);

        // Example: Retrieve document content
        $response = $service->documents->get($documentId);
        $docName = $response->getTitle();

        documents_id::create([
            'document_id' => $documentId,
            'name' => $docName,
            'user' => $userName,
        ]);

        $doc = documents_id::where('document_id', $documentId)->first();

        return $doc;
    }

    function deleteGoogleDoc($id)
    {
        // return "test";
        $doc = documents_id::where('id', $id)->first();
        $doc->delete();

        
    }

    public function getUserDocs()
    {
        $user = Auth::user();

        // Instantiate the Google API client
        $client = new Client();
        $client->setAuthConfig(public_path('google_docs_client_secret.json'));
        $client->setAccessToken($user->access_token);

        // Create a Google Drive service instance
        $service = new Drive($client);

        // List all Google Docs files
        $files = $service->files->listFiles();

        return $files->getFiles();
    }
}
