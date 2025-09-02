<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>CMS API Documentation</title>

    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset("/vendor/scribe/css/theme-default.style.css") }}" media="screen">
    <link rel="stylesheet" href="{{ asset("/vendor/scribe/css/theme-default.print.css") }}" media="print">

    <script src="https://cdn.jsdelivr.net/npm/lodash@4.17.10/lodash.min.js"></script>

    <link rel="stylesheet"
          href="https://unpkg.com/@highlightjs/cdn-assets@11.6.0/styles/obsidian.min.css">
    <script src="https://unpkg.com/@highlightjs/cdn-assets@11.6.0/highlight.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jets/0.14.1/jets.min.js"></script>

    <style id="language-style">
        /* starts out as display none and is replaced with js later  */
                    body .content .bash-example code { display: none; }
                    body .content .javascript-example code { display: none; }
            </style>

    <script>
        var tryItOutBaseUrl = "https://companymanagementsystems-back-qa.chetu.com";
        var useCsrf = Boolean();
        var csrfUrl = "/sanctum/csrf-cookie";
    </script>
    <script src="{{ asset("/vendor/scribe/js/tryitout-5.3.0.js") }}"></script>

    <script src="{{ asset("/vendor/scribe/js/theme-default-5.3.0.js") }}"></script>

</head>

<body data-languages="[&quot;bash&quot;,&quot;javascript&quot;]">

<a href="#" id="nav-button">
    <span>
        MENU
        <img src="{{ asset("/vendor/scribe/images/navbar.png") }}" alt="navbar-image"/>
    </span>
</a>
<div class="tocify-wrapper">
    
            <div class="lang-selector">
                                            <button type="button" class="lang-button" data-language-name="bash">bash</button>
                                            <button type="button" class="lang-button" data-language-name="javascript">javascript</button>
                    </div>
    
    <div class="search">
        <input type="text" class="search" id="input-search" placeholder="Search">
    </div>

    <div id="toc">
                    <ul id="tocify-header-introduction" class="tocify-header">
                <li class="tocify-item level-1" data-unique="introduction">
                    <a href="#introduction">Introduction</a>
                </li>
                            </ul>
                    <ul id="tocify-header-authenticating-requests" class="tocify-header">
                <li class="tocify-item level-1" data-unique="authenticating-requests">
                    <a href="#authenticating-requests">Authenticating requests</a>
                </li>
                            </ul>
                    <ul id="tocify-header-endpoints" class="tocify-header">
                <li class="tocify-item level-1" data-unique="endpoints">
                    <a href="#endpoints">Endpoints</a>
                </li>
                                    <ul id="tocify-subheader-endpoints" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="endpoints-POSTapi-v1-create-toolbox-talk">
                                <a href="#endpoints-POSTapi-v1-create-toolbox-talk">Create a toolbox talk.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-v1-createdByMe-talks">
                                <a href="#endpoints-GETapi-v1-createdByMe-talks">Retrieve all toolbox talks data which is created.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-v1-toolbox-talk--id--">
                                <a href="#endpoints-GETapi-v1-toolbox-talk--id--">Get details of a single toolbox talk by ID.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-v1-delete-url-pdf">
                                <a href="#endpoints-POSTapi-v1-delete-url-pdf">Delete a video URL or attachment PDF by attachment_id.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-v1-delete-selected-talks">
                                <a href="#endpoints-POSTapi-v1-delete-selected-talks">Delete a toolbox talk by toolboxTalk_ids into array.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-v1-assignToMe-talks">
                                <a href="#endpoints-GETapi-v1-assignToMe-talks">Retrieve all assigned to me toolbox talks data which is assigned to authentication (auth) user.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-v1-update-attachments">
                                <a href="#endpoints-POSTapi-v1-update-attachments">Update the attachments PDF's OR Video Resource Url's of a toolbox talk.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-v1-update-questions">
                                <a href="#endpoints-POSTapi-v1-update-questions">Update the questions sheet with options and correct answer of a toolbox talk.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-v1-company-library-toolbox-talks">
                                <a href="#endpoints-GETapi-v1-company-library-toolbox-talks">Retrieve all company library toolbox talks data which is saved into toolbox talk library.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-v1-attempt-questions">
                                <a href="#endpoints-POSTapi-v1-attempt-questions">Attempt the questions sheet with correct answer of a toolbox talk.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-v1-update-new-assigned-toolbox">
                                <a href="#endpoints-POSTapi-v1-update-new-assigned-toolbox">Make a toolbox talk assigned to users.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-v1-assignedtome">
                                <a href="#endpoints-POSTapi-v1-assignedtome">Get details of an assigned toolbox talk by toolbox_talk_id which is assigned to me (asigned to authentication user AUTH user).</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-v1-delete-question--id-">
                                <a href="#endpoints-GETapi-v1-delete-question--id-">Delete a single question from question sheet of a toolbox talk by ID.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-v1-delete-selected-cms-library">
                                <a href="#endpoints-POSTapi-v1-delete-selected-cms-library">Delete a toolbox talk by toolbox_talk_id into array.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-v1-update-video-pdf-status">
                                <a href="#endpoints-POSTapi-v1-update-video-pdf-status">Update the video status OR PDF status of a toolbox talk.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-v1-get-questions-options">
                                <a href="#endpoints-POSTapi-v1-get-questions-options">Get details of questions with their options by toolbox_talk_id.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-v1-video-pdf-status">
                                <a href="#endpoints-POSTapi-v1-video-pdf-status">Get video OR PDF status detail after watched or read by toolbox_talk_id.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-v1-acknowledged-status">
                                <a href="#endpoints-POSTapi-v1-acknowledged-status">Update the acknowledged status of a toolbox talk.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-v1-make-toolbox-copy">
                                <a href="#endpoints-POSTapi-v1-make-toolbox-copy">Make a copy of a toolbox talk.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-v1-update-content-toolboxtalk">
                                <a href="#endpoints-POSTapi-v1-update-content-toolboxtalk">Update the title or description of a toolbox talk.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-v1-export_toolbox_csv--id-">
                                <a href="#endpoints-GETapi-v1-export_toolbox_csv--id-">Get the detailed data of signoff sheet with title data of a toolbox talk.</a>
                            </li>
                                                                        </ul>
                            </ul>
            </div>

    <ul class="toc-footer" id="toc-footer">
                    <li style="padding-bottom: 5px;"><a href="{{ route("scribe.postman") }}">View Postman collection</a></li>
                            <li style="padding-bottom: 5px;"><a href="{{ route("scribe.openapi") }}">View OpenAPI spec</a></li>
                <li><a href="http://github.com/knuckleswtf/scribe">Documentation powered by Scribe ✍</a></li>
    </ul>

    <ul class="toc-footer" id="last-updated">
        <li>Last updated: August 29, 2025</li>
    </ul>
</div>

<div class="page-wrapper">
    <div class="dark-box"></div>
    <div class="content">
        <h1 id="introduction">Introduction</h1>
<p>This API documentation of CMS Desk Application.</p>
<aside>
    <strong>Base URL</strong>: <code>https://companymanagementsystems-back-qa.chetu.com</code>
</aside>
<pre><code>This documentation aims to provide all the information you need to work with our API.

As you scroll, you'll see code examples for working with the API in a php language according to framework of Laravel with version 12.
You can check all the detailed API's end points and params and other business logical factors also.</code></pre>

        <h1 id="authenticating-requests">Authenticating requests</h1>
<p>To authenticate requests, include an <strong><code>Authorization</code></strong> header with the value <strong><code>"Bearer {YOUR_AUTH_KEY}"</code></strong>.</p>
<p>All authenticated endpoints are marked with a <code>requires authentication</code> badge in the documentation below.</p>
<p>You can retrieve your token by visiting your dashboard and clicking <b>Generate API token</b>.</p>

        <h1 id="endpoints">Endpoints</h1>

    

                                <h2 id="endpoints-POSTapi-v1-create-toolbox-talk">Create a toolbox talk.</h2>

<p>
</p>

<p>This endpoint creates a toolbox. In this API when we create a toolbox talk then we need to choose one option from dropdown 'Send', 'Save in library' OR 'Send &amp; Save'. If we choose 'Send' OR 'Send &amp; Save' then we always need to select any role or departments or attendees or permissions and also 'Video URL Link' OR 'Upload PDF file'. And if we choose Save in Library then we don't need to select any users from ( roles, departments, permissions, attendees) and not need to put any 'Video URL Link' OR 'Upload PDF file'. The param name of dropdown list for 'Send' OR 'Save in library' OR 'Send &amp; Save' is 'isLibrary' param.</p>

<span id="example-requests-POSTapi-v1-create-toolbox-talk">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "https://companymanagementsystems-back-qa.chetu.com/api/v1/create-toolbox-talk" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"title\": \"consequatur\",
    \"select_user_detail\": \"- [{\\\"select_user_id\\\":\\\"4392\\\", \\\"user_name\\\":\\\"testing_name1\\\", \\\"user_email\\\":\\\"tpurposely@gmail.com\\\"}, {\\\"select_user_id\\\":\\\"4392\\\", \\\"user_name\\\":\\\"testing_name2\\\", \\\"user_email\\\":\\\"tpurposely1@yopmail.com\\\"}]\",
    \"due_date\": \"consequatur\",
    \"resource_url\": [
        \"http:\\/\\/kunze.biz\\/iste-laborum-eius-est-dolor.html\"
    ],
    \"pdf_file\": [
        \"consequatur\"
    ],
    \"description\": \"Dolores dolorum amet iste laborum eius est dolor.\",
    \"questions\": \"- [{\\\"text\\\":\\\"this is first question\\\", \\\"options\\\" : [ \\\"test1\\\", \\\"test2\\\", \\\"test3\\\", \\\"test4\\\"],\\\"correctAnswer\\\":\\\"1\\\"},{\\\"text\\\":\\\"this is second question\\\", \\\"options\\\" : [ \\\"test1\\\", \\\"test2\\\", \\\"test3\\\", \\\"test4\\\"], \\\"correctAnswer\\\":\\\"2\\\" }]\",
    \"attemptQuestions\": 17,
    \"number_of_correct_answer_to_pass\": 17,
    \"isLibrary\": 0
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://companymanagementsystems-back-qa.chetu.com/api/v1/create-toolbox-talk"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "title": "consequatur",
    "select_user_detail": "- [{\"select_user_id\":\"4392\", \"user_name\":\"testing_name1\", \"user_email\":\"tpurposely@gmail.com\"}, {\"select_user_id\":\"4392\", \"user_name\":\"testing_name2\", \"user_email\":\"tpurposely1@yopmail.com\"}]",
    "due_date": "consequatur",
    "resource_url": [
        "http:\/\/kunze.biz\/iste-laborum-eius-est-dolor.html"
    ],
    "pdf_file": [
        "consequatur"
    ],
    "description": "Dolores dolorum amet iste laborum eius est dolor.",
    "questions": "- [{\"text\":\"this is first question\", \"options\" : [ \"test1\", \"test2\", \"test3\", \"test4\"],\"correctAnswer\":\"1\"},{\"text\":\"this is second question\", \"options\" : [ \"test1\", \"test2\", \"test3\", \"test4\"], \"correctAnswer\":\"2\" }]",
    "attemptQuestions": 17,
    "number_of_correct_answer_to_pass": 17,
    "isLibrary": 0
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-create-toolbox-talk">
            <blockquote>
            <p>Example response (201):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;msg&quot;: &quot;Toolbox Talk created successfully&quot;,
    &quot;data&quot;: {
        &quot;title&quot;: &quot;new fresh without send and save&quot;,
        &quot;user_id&quot;: &quot;4392&quot;,
        &quot;number_of_questions_to_ask&quot;: &quot;1&quot;,
        &quot;number_of_correct_answer_to_pass&quot;: &quot;1&quot;,
        &quot;is_library&quot;: &quot;1&quot;,
        &quot;due_date&quot;: &quot;2025-08-26&quot;,
        &quot;description&quot;: &quot;This talk covers essential safety measures when working at heights, including the use of protective equipment, proper setup of ladders and scaffolding, and awareness of potential fall hazards.&quot;,
        &quot;updated_at&quot;: &quot;2025-08-26T11:24:48.000000Z&quot;,
        &quot;created_at&quot;: &quot;2025-08-26T11:24:48.000000Z&quot;,
        &quot;id&quot;: 59,
        &quot;status&quot;: &quot;0&quot;,
        &quot;is_created&quot;: &quot;1&quot;
    }
}</code>
 </pre>
            <blockquote>
            <p>Example response (422):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
 &quot;error&quot;: {
     &quot;name&quot;: [&quot;The title field is required.&quot;],
 }
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-v1-create-toolbox-talk" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-create-toolbox-talk"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-create-toolbox-talk"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-create-toolbox-talk" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-create-toolbox-talk">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-create-toolbox-talk" data-method="POST"
      data-path="api/v1/create-toolbox-talk"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-create-toolbox-talk', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-create-toolbox-talk"
                    onclick="tryItOut('POSTapi-v1-create-toolbox-talk');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-create-toolbox-talk"
                    onclick="cancelTryOut('POSTapi-v1-create-toolbox-talk');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-create-toolbox-talk"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/create-toolbox-talk</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v1-create-toolbox-talk"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-v1-create-toolbox-talk"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>title</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="title"                data-endpoint="POSTapi-v1-create-toolbox-talk"
               value="consequatur"
               data-component="body">
    <br>
<p>required. The title of the toolbox talk. Example: <code>consequatur</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>select_user_detail</code></b>&nbsp;&nbsp;
<small>json</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="select_user_detail"                data-endpoint="POSTapi-v1-create-toolbox-talk"
               value="- [{"select_user_id":"4392", "user_name":"testing_name1", "user_email":"tpurposely@gmail.com"}, {"select_user_id":"4392", "user_name":"testing_name2", "user_email":"tpurposely1@yopmail.com"}]"
               data-component="body">
    <br>
<p>array with some keys (objects). The users selected from dropdown list from attendees or roles or departments or permissions or select users. It is required while choose 'Send' OR 'Send &amp; Save'. But when we choose 'Save in library' then this param is optional. Example: <code>- [{"select_user_id":"4392", "user_name":"testing_name1", "user_email":"tpurposely@gmail.com"}, {"select_user_id":"4392", "user_name":"testing_name2", "user_email":"tpurposely1@yopmail.com"}]</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>due_date</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="due_date"                data-endpoint="POSTapi-v1-create-toolbox-talk"
               value="consequatur"
               data-component="body">
    <br>
<p>The Due date of toolbox talk. Ex:- &quot;2025-08-22&quot; Example: <code>consequatur</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>resource_url</code></b>&nbsp;&nbsp;
<small>string[]</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="resource_url[0]"                data-endpoint="POSTapi-v1-create-toolbox-talk"
               data-component="body">
        <input type="text" style="display: none"
               name="resource_url[1]"                data-endpoint="POSTapi-v1-create-toolbox-talk"
               data-component="body">
    <br>
<p>when 'pdf_file' is not present and choose only 'Send' OR 'Send &amp; Save' The 'Video URL Link' for a toolbox talk. Ex:- &quot;['youtube.com','testtubevideo.com' ]&quot;</p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>pdf_file</code></b>&nbsp;&nbsp;
<small>string[]</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="pdf_file[0]"                data-endpoint="POSTapi-v1-create-toolbox-talk"
               data-component="body">
        <input type="text" style="display: none"
               name="pdf_file[1]"                data-endpoint="POSTapi-v1-create-toolbox-talk"
               data-component="body">
    <br>
<p>when 'resource_url' is not present and choose only 'Send' OR 'Send &amp; Save' The 'Upload PDF File' for a toolbox talk. Ex:- &quot;['firstPDF.pdf','secondPDF.pdf' ]&quot;</p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>description</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="description"                data-endpoint="POSTapi-v1-create-toolbox-talk"
               value="Dolores dolorum amet iste laborum eius est dolor."
               data-component="body">
    <br>
<p>optional The description of the toolbox talk. Example: <code>Dolores dolorum amet iste laborum eius est dolor.</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>questions</code></b>&nbsp;&nbsp;
<small>json</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="questions"                data-endpoint="POSTapi-v1-create-toolbox-talk"
               value="- [{"text":"this is first question", "options" : [ "test1", "test2", "test3", "test4"],"correctAnswer":"1"},{"text":"this is second question", "options" : [ "test1", "test2", "test3", "test4"], "correctAnswer":"2" }]"
               data-component="body">
    <br>
<p>array with some keys (objects) optional. The Question Sheets for the toolbox talk. Example: <code>- [{"text":"this is first question", "options" : [ "test1", "test2", "test3", "test4"],"correctAnswer":"1"},{"text":"this is second question", "options" : [ "test1", "test2", "test3", "test4"], "correctAnswer":"2" }]</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>attemptQuestions</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="attemptQuestions"                data-endpoint="POSTapi-v1-create-toolbox-talk"
               value="17"
               data-component="body">
    <br>
<p>when we choose 'questions' the Question Sheets for the toolbox talk. In this Number of Questions to Ask per Participant(attemptQuestions) is always greater then Number of Correct Answers Required to Pass(number_of_correct_answer_to_pass). Example: <code>17</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>number_of_correct_answer_to_pass</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="number_of_correct_answer_to_pass"                data-endpoint="POSTapi-v1-create-toolbox-talk"
               value="17"
               data-component="body">
    <br>
<p>when we choose 'questions' the Question Sheets for the toolbox talk. In this Number of Correct Answers Required to Pass(number_of_correct_answer_to_pass) is always less then Number of Questions to Ask per Participant(attemptQuestions). Example: <code>17</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>isLibrary</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="isLibrary"                data-endpoint="POSTapi-v1-create-toolbox-talk"
               value="0"
               data-component="body">
    <br>
<p>when we select options from dropdown list then we send the values in this params 1, 2 or 3. Example: <code>0</code></p>
        </div>
        </form>

                    <h2 id="endpoints-GETapi-v1-createdByMe-talks">Retrieve all toolbox talks data which is created.</h2>

<p>
</p>

<p>This endpoint returns all toolbox talks data. In this API, we get all toolbox talk data and also we can filter through assigned or unassigned status that toolbox tallk is in assigned status or unassigned status. We can do search, filter by dates from all toolbox talks.</p>

<span id="example-requests-GETapi-v1-createdByMe-talks">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "https://companymanagementsystems-back-qa.chetu.com/api/v1/createdByMe-talks?no=consequatur" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://companymanagementsystems-back-qa.chetu.com/api/v1/createdByMe-talks"
);

const params = {
    "no": "consequatur",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-createdByMe-talks">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
     &quot;message&quot;: &quot;Toolbox Talks fetched successfully&quot;,
     &quot;toolboxTalks&quot;: {
          &quot;data&quot;: [
              {
                  &quot;id&quot;: 8,
                  &quot;title&quot;: &quot;Test new again&quot;,
                  &quot;video_url&quot;: null,
                  &quot;number_of_questions_to_ask&quot;: null,
                  &quot;number_of_correct_answer_to_pass&quot;: null,
                  &quot;file&quot;: null,
                  &quot;description&quot;: &quot;&quot;,
                  &quot;user_id&quot;: 4392,
                  &quot;is_library&quot;: &quot;3&quot;,
                  &quot;is_library_deleted&quot;: &quot;2&quot;,
                  &quot;due_date&quot;: &quot;2025-08-27&quot;,
                  &quot;deleted_at&quot;: null,
                  &quot;status&quot;: &quot;1&quot;,
                  &quot;is_created&quot;: &quot;1&quot;,
                  &quot;created_at&quot;: &quot;2025-08-27T14:35:44.000000Z&quot;,
                  &quot;updated_at&quot;: &quot;2025-08-27T14:35:52.000000Z&quot;,
                  &quot;get_assigned_users_count&quot;: 5,
                  &quot;get_count_completed_count&quot;: 0
              },
              {
                  &quot;id&quot;: 7,
                  &quot;title&quot;: &quot;Testing new &quot;,
                  &quot;video_url&quot;: null,
                  &quot;number_of_questions_to_ask&quot;: null,
                  &quot;number_of_correct_answer_to_pass&quot;: null,
                  &quot;file&quot;: null,
                  &quot;description&quot;: &quot;&quot;,
                  &quot;user_id&quot;: 4392,
                  &quot;is_library&quot;: &quot;3&quot;,
                  &quot;is_library_deleted&quot;: &quot;2&quot;,
                  &quot;due_date&quot;: &quot;2025-08-27&quot;,
                  &quot;deleted_at&quot;: null,
                  &quot;status&quot;: &quot;1&quot;,
                  &quot;is_created&quot;: &quot;1&quot;,
                  &quot;created_at&quot;: &quot;2025-08-27T14:34:51.000000Z&quot;,
                  &quot;updated_at&quot;: &quot;2025-08-27T14:34:55.000000Z&quot;,
                  &quot;get_assigned_users_count&quot;: 1,
                  &quot;get_count_completed_count&quot;: 0
              },
          ],
          &quot;links&quot;: {&quot;first&quot;: &quot;https://companymanagementsystems-back-qa.chetu.com/api/v1/createdByMe-talks?page=1&quot;, &quot;last&quot;: &quot;https://companymanagementsystems-back-qa.chetu.com/api/v1/createdByMe-talks?page=1&quot;, &quot;prev&quot;: null,&quot;next&quot;: null},
          &quot;meta&quot;: { &quot;current_page&quot;: 1, &quot;from&quot;: 1, &quot;last_page&quot;: 1,
          &quot;links&quot;: [{&quot;url&quot;: null, &quot;label&quot;: &quot;&amp;laquo; Previous&quot;, &quot;active&quot;: false}, {&quot;url&quot;: &quot;https://companymanagementsystems-back-qa.chetu.com/api/v1/createdByMe-talks?page=1&quot;,&quot;label&quot;: &quot;1&quot;,&quot;active&quot;: true}, { &quot;url&quot;: null, &quot;label&quot;: &quot;Next &amp;raquo;&quot;, &quot;active&quot;: false }],
          &quot;path&quot;: &quot;https://companymanagementsystems-back-qa.chetu.com/api/v1/createdByMe-talks&quot;, &quot;per_page&quot;: 10, &quot;to&quot;: 8, &quot;total&quot;: 8 }
      }
  }</code>
 </pre>
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;error&quot;: &quot;Data not found.&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (500):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;error&quot;: &quot;Failed to fetched toolbox talks: Something went wrong!&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-createdByMe-talks" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-createdByMe-talks"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-createdByMe-talks"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-createdByMe-talks" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-createdByMe-talks">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-createdByMe-talks" data-method="GET"
      data-path="api/v1/createdByMe-talks"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-createdByMe-talks', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-createdByMe-talks"
                    onclick="tryItOut('GETapi-v1-createdByMe-talks');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-createdByMe-talks"
                    onclick="cancelTryOut('GETapi-v1-createdByMe-talks');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-createdByMe-talks"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/createdByMe-talks</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-createdByMe-talks"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-createdByMe-talks"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>no</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="no"                data-endpoint="GETapi-v1-createdByMe-talks"
               value="consequatur"
               data-component="query">
    <br>
<p>need of any param initial. If we want to search or filter or sorted any toolbox talk then we need to put query params while we are searching then we need to put 'search' &amp; for getting assigned or unassigned then we need to put 'status' param and 'start_date' &amp; 'end_date' when we want to filter according to the dates from calender. Example: <code>consequatur</code></p>
            </div>
                </form>

                    <h2 id="endpoints-GETapi-v1-toolbox-talk--id--">Get details of a single toolbox talk by ID.</h2>

<p>
</p>

<p>This endpoint returns detailed information about a toolbox talk when their ID is provided as a query parameter. This API is providing the details of a single toolbox talk which have all data of questions sheet with options and correct answers and also fetching the data of documents like video URL links or PDF's data. Now if we are getting the data of assigned users then this toolbox is already assigned to some users or whatever we are getting data of this user in below response &amp; apart from this we are getting details of that user also who has created this Toolbox talk.</p>

<span id="example-requests-GETapi-v1-toolbox-talk--id--">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "https://companymanagementsystems-back-qa.chetu.com/api/v1/toolbox-talk/consequatur?id=17" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://companymanagementsystems-back-qa.chetu.com/api/v1/toolbox-talk/consequatur"
);

const params = {
    "id": "17",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-toolbox-talk--id--">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;talkDetails&quot;: {
        &quot;id&quot;: 58,
        &quot;title&quot;: &quot;new fresh test1&quot;,
        &quot;number_of_questions_to_ask&quot;: 1,
        &quot;number_of_correct_answer_to_pass&quot;: 1,
        &quot;description&quot;: &quot;This talk covers essential safety measures when working at heights, including the use of protective equipment, proper setup of ladders and scaffolding, and awareness of potential fall hazards.&quot;,
        &quot;user_id&quot;: 4392,
        &quot;is_library&quot;: &quot;2&quot;,
        &quot;due_date&quot;: &quot;2025-08-26&quot;,
        &quot;deleted_at&quot;: null,
        &quot;status&quot;: &quot;1&quot;,
        &quot;created_at&quot;: &quot;2025-08-26T10:54:33.000000Z&quot;,
        &quot;updated_at&quot;: &quot;2025-08-26T10:54:37.000000Z&quot;,
        &quot;questions&quot;: [
            {
                &quot;id&quot;: 167,
                &quot;name&quot;: &quot;this is first question&quot;,
                &quot;options&quot;: [
                    {
                        &quot;id&quot;: 665,
                        &quot;name&quot;: &quot;test1&quot;
                    },
                    {
                        &quot;id&quot;: 666,
                        &quot;name&quot;: &quot;test2&quot;
                    },
                    {
                        &quot;id&quot;: 667,
                        &quot;name&quot;: &quot;test3&quot;
                    },
                    {
                        &quot;id&quot;: 668,
                        &quot;name&quot;: &quot;test4&quot;
                    }
                ],
                &quot;correct_answer&quot;: [
                    {
                        &quot;id&quot;: 665,
                        &quot;name&quot;: &quot;test1&quot;
                    }
                ]
            },
            {
                &quot;id&quot;: 167,
                &quot;name&quot;: &quot;this is second question&quot;,
                &quot;options&quot;: [
                    {
                        &quot;id&quot;: 770,
                        &quot;name&quot;: &quot;A&quot;
                    },
                    {
                        &quot;id&quot;: 771,
                        &quot;name&quot;: &quot;B&quot;
                    },
                    {
                        &quot;id&quot;: 772,
                        &quot;name&quot;: &quot;C&quot;
                    },
                    {
                        &quot;id&quot;: 773,
                        &quot;name&quot;: &quot;D&quot;
                    }
                ],
                &quot;correct_answer&quot;: [
                    {
                        &quot;id&quot;: 772,
                        &quot;name&quot;: &quot;C&quot;
                    }
                ]
            }
        ],
        &quot;video_url&quot;: [],
        &quot;file_data&quot;: [
            {
                &quot;id&quot;: 49,
                &quot;toolbox_talk_id&quot;: 58,
                &quot;file_url&quot;: &quot;https://companymanagementsystems-back-qa.chetu.com/storage/toolbox_talks/toolbox_talk_58311756205673.pdf&quot;,
                &quot;file_name&quot;: &quot;toolbox_talk_58311756205673.pdf&quot;,
                &quot;file_status&quot;: &quot;1&quot;,
                &quot;file_state&quot;: &quot;Completed&quot;
            }
        ],
        &quot;assigned_users&quot;: [
            {
                &quot;id&quot;: 113,
                &quot;name&quot;: &quot;testing_name1&quot;,
                &quot;status&quot;: &quot;&quot;,
                &quot;attempt&quot;: null,
                &quot;time&quot;: null,
                &quot;date&quot;: null,
                &quot;result&quot;: {
                    &quot;result&quot;: &quot;0/0&quot;
                }
            }
        ],
        &quot;created_by_user&quot;: null
    },
    &quot;status&quot;: 200
}</code>
 </pre>
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;error&quot;: &quot;Toolbox talk data not found&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-toolbox-talk--id--" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-toolbox-talk--id--"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-toolbox-talk--id--"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-toolbox-talk--id--" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-toolbox-talk--id--">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-toolbox-talk--id--" data-method="GET"
      data-path="api/v1/toolbox-talk/{id?}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-toolbox-talk--id--', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-toolbox-talk--id--"
                    onclick="tryItOut('GETapi-v1-toolbox-talk--id--');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-toolbox-talk--id--"
                    onclick="cancelTryOut('GETapi-v1-toolbox-talk--id--');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-toolbox-talk--id--"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/toolbox-talk/{id?}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-toolbox-talk--id--"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-toolbox-talk--id--"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="id"                data-endpoint="GETapi-v1-toolbox-talk--id--"
               value="consequatur"
               data-component="url">
    <br>
<p>The ID of the . Example: <code>consequatur</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="GETapi-v1-toolbox-talk--id--"
               value="17"
               data-component="query">
    <br>
<p>The ID of the toolbox talk. Example: <code>17</code></p>
            </div>
                </form>

                    <h2 id="endpoints-POSTapi-v1-delete-url-pdf">Delete a video URL or attachment PDF by attachment_id.</h2>

<p>
</p>

<p>This endpoint deletes a Video URL Link or Attachments specified by its IDs in the request body in an array and given toolbox_talk_id also for identiying.</p>

<span id="example-requests-POSTapi-v1-delete-url-pdf">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "https://companymanagementsystems-back-qa.chetu.com/api/v1/delete-url-pdf" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"attachment_id\": 17,
    \"toolbox_talk_id\": 17
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://companymanagementsystems-back-qa.chetu.com/api/v1/delete-url-pdf"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "attachment_id": 17,
    "toolbox_talk_id": 17
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-delete-url-pdf">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Attachment is deleted successfully.&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;error&quot;: &quot;Data not found.&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (500):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;error&quot;: &quot;Failed to delete attachments: Something went wrong!&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-v1-delete-url-pdf" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-delete-url-pdf"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-delete-url-pdf"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-delete-url-pdf" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-delete-url-pdf">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-delete-url-pdf" data-method="POST"
      data-path="api/v1/delete-url-pdf"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-delete-url-pdf', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-delete-url-pdf"
                    onclick="tryItOut('POSTapi-v1-delete-url-pdf');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-delete-url-pdf"
                    onclick="cancelTryOut('POSTapi-v1-delete-url-pdf');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-delete-url-pdf"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/delete-url-pdf</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v1-delete-url-pdf"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-v1-delete-url-pdf"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>attachment_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="number" style="display: none"
               step="any"               name="attachment_id"                data-endpoint="POSTapi-v1-delete-url-pdf"
               value="17"
               data-component="body">
    <br>
<p>array required The attachment_id of the attachment or video URL link table to delete. Example: <code>17</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>toolbox_talk_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="toolbox_talk_id"                data-endpoint="POSTapi-v1-delete-url-pdf"
               value="17"
               data-component="body">
    <br>
<p>The toolbox_talk_id of the toolbox talk. Example: <code>17</code></p>
        </div>
        </form>

                    <h2 id="endpoints-POSTapi-v1-delete-selected-talks">Delete a toolbox talk by toolboxTalk_ids into array.</h2>

<p>
</p>

<p>This endpoint deletes a toolbox talk specified by its IDs in the request body in an array. In this API we can delete multiple toolbox talks together or we can delete only single at a time.</p>

<span id="example-requests-POSTapi-v1-delete-selected-talks">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "https://companymanagementsystems-back-qa.chetu.com/api/v1/delete-selected-talks" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"toolboxTalk_ids\": 17
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://companymanagementsystems-back-qa.chetu.com/api/v1/delete-selected-talks"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "toolboxTalk_ids": 17
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-delete-selected-talks">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Selected Toolbox Talk have been deleted successfully.&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;error&quot;: &quot;Data not found.&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (500):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;error&quot;: &quot;Failed to delete toolbox talks: Something went wrong!&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-v1-delete-selected-talks" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-delete-selected-talks"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-delete-selected-talks"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-delete-selected-talks" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-delete-selected-talks">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-delete-selected-talks" data-method="POST"
      data-path="api/v1/delete-selected-talks"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-delete-selected-talks', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-delete-selected-talks"
                    onclick="tryItOut('POSTapi-v1-delete-selected-talks');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-delete-selected-talks"
                    onclick="cancelTryOut('POSTapi-v1-delete-selected-talks');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-delete-selected-talks"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/delete-selected-talks</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v1-delete-selected-talks"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-v1-delete-selected-talks"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>toolboxTalk_ids</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="number" style="display: none"
               step="any"               name="toolboxTalk_ids"                data-endpoint="POSTapi-v1-delete-selected-talks"
               value="17"
               data-component="body">
    <br>
<p>array required The toolboxTalk_ids of the toolbox talks to delete. Example: <code>17</code></p>
        </div>
        </form>

                    <h2 id="endpoints-GETapi-v1-assignToMe-talks">Retrieve all assigned to me toolbox talks data which is assigned to authentication (auth) user.</h2>

<p>
</p>

<p>This endpoint returns all assigned to me toolbox talks data. In this API, we get all assigned to me toolbox talks data and also we can filter through ongoing or completed or ended status that toolbox tallk is in ongoing status (means need to take or attempt the question sheet or acknowledged toolbox talk) or completed status(means attempt done or acknowledged successfully toolbox talk) or ended status(means toolbox talk has been expired). We can do search, filter by dates from all assigned to me toolbox talks.</p>

<span id="example-requests-GETapi-v1-assignToMe-talks">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "https://companymanagementsystems-back-qa.chetu.com/api/v1/assignToMe-talks?no=consequatur" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://companymanagementsystems-back-qa.chetu.com/api/v1/assignToMe-talks"
);

const params = {
    "no": "consequatur",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-assignToMe-talks">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
     &quot;status&quot;: 200,
     &quot;message&quot;: &quot;Successfully fetched Toolbox Talks that are assigned to you.&quot;,
      &quot;assignToMeToolboxTalks&quot;: {
          &quot;data&quot;: [
          {
              &quot;id&quot;: 44,
              &quot;role_id&quot;: null,
              &quot;permission_id&quot;: null,
              &quot;toolbox_talk_id&quot;: 8,
              &quot;user_email&quot;: &quot;chandrakeshp@chetu.com&quot;,
              &quot;user_name&quot;: &quot;Chandrakesh Pandey&quot;,
              &quot;due_date&quot;: &quot;2025-08-27&quot;,
              &quot;user_id&quot;: 4392,
              &quot;status&quot;: &quot;3&quot;,
              &quot;result&quot;: null,
              &quot;attempt_count&quot;: null,
              &quot;date_time&quot;: null,
              &quot;created_at&quot;: &quot;2025-08-27T14:35:44.000000Z&quot;,
              &quot;updated_at&quot;: &quot;2025-08-27T14:35:44.000000Z&quot;,
              &quot;deleted_at&quot;: null,
              &quot;get_toolbox_talk_count&quot;: 1,
              &quot;get_toolbox_talk&quot;: {
                  &quot;id&quot;: 8,
                  &quot;title&quot;: &quot;Test new again&quot;,
                  &quot;video_url&quot;: null,
                  &quot;number_of_questions_to_ask&quot;: null,
                  &quot;number_of_correct_answer_to_pass&quot;: null,
                  &quot;file&quot;: null,
                  &quot;description&quot;: &quot;&quot;,
                  &quot;user_id&quot;: 4392,
                  &quot;is_library&quot;: &quot;3&quot;,
                  &quot;is_library_deleted&quot;: &quot;2&quot;,
                  &quot;due_date&quot;: &quot;2025-08-27&quot;,
                  &quot;deleted_at&quot;: null,
                  &quot;status&quot;: &quot;1&quot;,
                  &quot;is_created&quot;: &quot;1&quot;,
                  &quot;created_at&quot;: &quot;2025-08-27T14:35:44.000000Z&quot;,
                  &quot;updated_at&quot;: &quot;2025-08-27T14:35:52.000000Z&quot;,
                  &quot;get_created_by_user&quot;: null,
                  &quot;questions&quot;: [],
                  &quot;get_assigned_users&quot;: [
                      {
                          &quot;id&quot;: 42,
                          &quot;role_id&quot;: null,
                          &quot;permission_id&quot;: null,
                          &quot;toolbox_talk_id&quot;: 8,
                          &quot;user_email&quot;: &quot;akashs@chetu.com&quot;,
                          &quot;user_name&quot;: &quot;Akash Sinha&quot;,
                          &quot;due_date&quot;: &quot;2025-08-27&quot;,
                          &quot;user_id&quot;: 4379,
                          &quot;status&quot;: &quot;3&quot;,
                          &quot;result&quot;: null,
                          &quot;attempt_count&quot;: null,
                          &quot;date_time&quot;: null,
                          &quot;created_at&quot;: &quot;2025-08-27T14:35:44.000000Z&quot;,
                          &quot;updated_at&quot;: &quot;2025-08-27T14:35:44.000000Z&quot;,
                          &quot;deleted_at&quot;: null,
                          &quot;assigned_users&quot;: null
                      },
                      {
                          &quot;id&quot;: 43,
                          &quot;role_id&quot;: null,
                          &quot;permission_id&quot;: null,
                          &quot;toolbox_talk_id&quot;: 8,
                          &quot;user_email&quot;: &quot;armaanl@chetu.com&quot;,
                          &quot;user_name&quot;: &quot;armaan lodi&quot;,
                          &quot;due_date&quot;: &quot;2025-08-27&quot;,
                          &quot;user_id&quot;: 4723,
                          &quot;status&quot;: &quot;3&quot;,
                          &quot;result&quot;: null,
                          &quot;attempt_count&quot;: null,
                          &quot;date_time&quot;: null,
                          &quot;created_at&quot;: &quot;2025-08-27T14:35:44.000000Z&quot;,
                          &quot;updated_at&quot;: &quot;2025-08-27T14:35:44.000000Z&quot;,
                          &quot;deleted_at&quot;: null,
                          &quot;assigned_users&quot;: null
                      }
                  ],
                  &quot;resource_url_data&quot;: [
                      {
                          &quot;id&quot;: 7,
                          &quot;user_id&quot;: 4392,
                          &quot;toolbox_talk_id&quot;: 8,
                          &quot;video_url&quot;: &quot;https://static.vecteezy.com/system/resources/previews/008/259/475/mp4/wooden-dummy-training-in-wing-chun-kung-fu-a-man-practicing-wing-chun-video.mp4&quot;,
                          &quot;video_description&quot;: null,
                          &quot;video_status&quot;: &quot;1&quot;,
                          &quot;video_state&quot;: &quot;Completed&quot;,
                          &quot;deleted_at&quot;: null,
                          &quot;created_at&quot;: null,
                          &quot;updated_at&quot;: &quot;2025-08-27T14:38:05.000000Z&quot;
                      }
                  ],
                  &quot;attachments_pdf_data&quot;: []
              }
          },
          ]
     }</code>
 </pre>
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;error&quot;: &quot;Data not found.&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (500):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;error&quot;: &quot;Failed to fetched toolbox talks: Something went wrong!&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-assignToMe-talks" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-assignToMe-talks"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-assignToMe-talks"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-assignToMe-talks" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-assignToMe-talks">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-assignToMe-talks" data-method="GET"
      data-path="api/v1/assignToMe-talks"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-assignToMe-talks', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-assignToMe-talks"
                    onclick="tryItOut('GETapi-v1-assignToMe-talks');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-assignToMe-talks"
                    onclick="cancelTryOut('GETapi-v1-assignToMe-talks');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-assignToMe-talks"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/assignToMe-talks</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-assignToMe-talks"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-assignToMe-talks"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>no</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="no"                data-endpoint="GETapi-v1-assignToMe-talks"
               value="consequatur"
               data-component="query">
    <br>
<p>need of any param at initial. If we want to search or filter or sorted any toolbox talk then we need to put query params while we are searching then we need to put 'search' &amp; for getting ongoing or completed or ended then we need to put 'status' param and 'start_date' &amp; 'end_date' when we want to filter according to the dates from calender. Example: <code>consequatur</code></p>
            </div>
                </form>

                    <h2 id="endpoints-POSTapi-v1-update-attachments">Update the attachments PDF&#039;s OR Video Resource Url&#039;s of a toolbox talk.</h2>

<p>
</p>

<p>This endpoint updates the attachments PDF's OR Video Resource Url's of a toolbox talk. In this API, while we are updating the attachments PDF's or Video Resource URL's of a toolbox talk, we need to send toolbox_talk_id, resource_url in array OR pdf_file in array.</p>

<span id="example-requests-POSTapi-v1-update-attachments">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "https://companymanagementsystems-back-qa.chetu.com/api/v1/update-attachments" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"toolbox_talk_id\": \"consequatur\",
    \"resource_url\": [
        \"http:\\/\\/kunze.biz\\/iste-laborum-eius-est-dolor.html\"
    ],
    \"pdf_file\": [
        \"consequatur\"
    ]
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://companymanagementsystems-back-qa.chetu.com/api/v1/update-attachments"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "toolbox_talk_id": "consequatur",
    "resource_url": [
        "http:\/\/kunze.biz\/iste-laborum-eius-est-dolor.html"
    ],
    "pdf_file": [
        "consequatur"
    ]
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-update-attachments">
            <blockquote>
            <p>Example response (201):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
 &quot;message&quot;: &quot;Attachments updated successfully&quot;,
 &quot;Updated_Toolbox_Talk&quot;: {
         &quot;id&quot;: 1,
         &quot;title&quot;: &quot;new fresh test1&quot;,
         &quot;number_of_questions_to_ask&quot;: 1,
         &quot;number_of_correct_answer_to_pass&quot;: 1,
         &quot;description&quot;: &quot;This talk covers essential safety measures when working at heights, including the use of protective equipment, proper setup of ladders and scaffolding, and awareness of potential fall hazards.&quot;,
         &quot;user_id&quot;: 4392,
         &quot;is_library&quot;: &quot;2&quot;,
         &quot;due_date&quot;: &quot;2025-08-26&quot;,
         &quot;deleted_at&quot;: null,
         &quot;status&quot;: &quot;1&quot;,
         &quot;created_at&quot;: &quot;2025-08-26T10:54:33.000000Z&quot;,
         &quot;updated_at&quot;: &quot;2025-08-26T10:54:37.000000Z&quot;,
      }
}</code>
 </pre>
            <blockquote>
            <p>Example response (422):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
 &quot;error&quot;: {
     &quot;toolbox_talk_id&quot;: [&quot;The toolbox_talk_id field is required.&quot;],
 }
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-v1-update-attachments" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-update-attachments"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-update-attachments"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-update-attachments" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-update-attachments">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-update-attachments" data-method="POST"
      data-path="api/v1/update-attachments"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-update-attachments', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-update-attachments"
                    onclick="tryItOut('POSTapi-v1-update-attachments');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-update-attachments"
                    onclick="cancelTryOut('POSTapi-v1-update-attachments');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-update-attachments"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/update-attachments</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v1-update-attachments"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-v1-update-attachments"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>toolbox_talk_id</code></b>&nbsp;&nbsp;
<small>interger</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="toolbox_talk_id"                data-endpoint="POSTapi-v1-update-attachments"
               value="consequatur"
               data-component="body">
    <br>
<p>required. The toolbox_talk_id of the toolbox talk. Example: <code>consequatur</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>resource_url</code></b>&nbsp;&nbsp;
<small>string[]</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="resource_url[0]"                data-endpoint="POSTapi-v1-update-attachments"
               data-component="body">
        <input type="text" style="display: none"
               name="resource_url[1]"                data-endpoint="POSTapi-v1-update-attachments"
               data-component="body">
    <br>
<p>when 'pdf_file' is not present. The 'Video URL Link' for a toolbox talk. Ex:- &quot;['youtube.com','testtubevideo.com' ]&quot;</p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>pdf_file</code></b>&nbsp;&nbsp;
<small>string[]</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="pdf_file[0]"                data-endpoint="POSTapi-v1-update-attachments"
               data-component="body">
        <input type="text" style="display: none"
               name="pdf_file[1]"                data-endpoint="POSTapi-v1-update-attachments"
               data-component="body">
    <br>
<p>when 'resource_url' is not present. The 'Upload PDF File' for a toolbox talk. Ex:- &quot;['firstPDF.pdf','secondPDF.pdf' ]&quot;</p>
        </div>
        </form>

                    <h2 id="endpoints-POSTapi-v1-update-questions">Update the questions sheet with options and correct answer of a toolbox talk.</h2>

<p>
</p>

<p>This endpoint updates the question sheet with options and correct answer of a toolbox talk. In this API, while we are updating the question sheet with options and correct answer of a toolbox talk, we need to send toolbox_talk_id, questions in json array with some keys (objects), Number of Questions to Ask per Participant, Number of Correct Answers Required to Pass &amp; New questions add if wants to add.</p>

<span id="example-requests-POSTapi-v1-update-questions">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "https://companymanagementsystems-back-qa.chetu.com/api/v1/update-questions" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"toolbox_talk_id\": \"consequatur\",
    \"questions\": \"- [{\\\"text\\\":\\\"this is updated first question\\\", \\\"options\\\" : [ \\\"test11\\\", \\\"test22\\\", \\\"test33\\\", \\\"test44\\\"],\\\"correctAnswer\\\":\\\"4\\\"},{\\\"text\\\":\\\"this is updated second question\\\", \\\"options\\\" : [ \\\"test111\\\", \\\"test222\\\", \\\"test333\\\", \\\"test444\\\"], \\\"correctAnswer\\\":\\\"1\\\" }]\",
    \"attemptQuestions\": 17,
    \"number_of_correct_answer_to_pass\": 17,
    \"new_questions\": \"- [{\\\"text\\\":\\\"this is new extra first question\\\", \\\"options\\\" : [ \\\"test11\\\", \\\"test22\\\", \\\"test33\\\", \\\"test44\\\"],\\\"correctAnswer\\\":\\\"4\\\"},{\\\"text\\\":\\\"this is new extra second question\\\", \\\"options\\\" : [ \\\"test111\\\", \\\"test222\\\", \\\"test333\\\", \\\"test444\\\"], \\\"correctAnswer\\\":\\\"1\\\" }]\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://companymanagementsystems-back-qa.chetu.com/api/v1/update-questions"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "toolbox_talk_id": "consequatur",
    "questions": "- [{\"text\":\"this is updated first question\", \"options\" : [ \"test11\", \"test22\", \"test33\", \"test44\"],\"correctAnswer\":\"4\"},{\"text\":\"this is updated second question\", \"options\" : [ \"test111\", \"test222\", \"test333\", \"test444\"], \"correctAnswer\":\"1\" }]",
    "attemptQuestions": 17,
    "number_of_correct_answer_to_pass": 17,
    "new_questions": "- [{\"text\":\"this is new extra first question\", \"options\" : [ \"test11\", \"test22\", \"test33\", \"test44\"],\"correctAnswer\":\"4\"},{\"text\":\"this is new extra second question\", \"options\" : [ \"test111\", \"test222\", \"test333\", \"test444\"], \"correctAnswer\":\"1\" }]"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-update-questions">
            <blockquote>
            <p>Example response (201):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
 &quot;message&quot;: &quot;Questions updated successfully.&quot;,
 &quot;Toolbox_Talk&quot;: {
         &quot;id&quot;: 1,
         &quot;title&quot;: &quot;new fresh test1&quot;,
         &quot;number_of_questions_to_ask&quot;: 1,
         &quot;number_of_correct_answer_to_pass&quot;: 1,
         &quot;description&quot;: &quot;This talk covers essential safety measures when working at heights, including the use of protective equipment, proper setup of ladders and scaffolding, and awareness of potential fall hazards.&quot;,
         &quot;user_id&quot;: 4392,
         &quot;is_library&quot;: &quot;2&quot;,
         &quot;due_date&quot;: &quot;2025-08-26&quot;,
         &quot;deleted_at&quot;: null,
         &quot;is_created&quot;: &quot;1&quot;,
         &quot;status&quot;: &quot;1&quot;,
         &quot;created_at&quot;: &quot;2025-08-26T10:54:33.000000Z&quot;,
         &quot;updated_at&quot;: &quot;2025-08-26T10:54:37.000000Z&quot;,
      }
}</code>
 </pre>
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;error&quot;: &quot;Question not found for ID.&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (422):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
 &quot;error&quot;: {
     &quot;toolbox_talk_id&quot;: [&quot;The toolbox_talk_id field is required.&quot;],
 }
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-v1-update-questions" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-update-questions"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-update-questions"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-update-questions" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-update-questions">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-update-questions" data-method="POST"
      data-path="api/v1/update-questions"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-update-questions', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-update-questions"
                    onclick="tryItOut('POSTapi-v1-update-questions');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-update-questions"
                    onclick="cancelTryOut('POSTapi-v1-update-questions');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-update-questions"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/update-questions</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v1-update-questions"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-v1-update-questions"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>toolbox_talk_id</code></b>&nbsp;&nbsp;
<small>interger</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="toolbox_talk_id"                data-endpoint="POSTapi-v1-update-questions"
               value="consequatur"
               data-component="body">
    <br>
<p>required. The toolbox_talk_id of the toolbox talk. Example: <code>consequatur</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>questions</code></b>&nbsp;&nbsp;
<small>json</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="questions"                data-endpoint="POSTapi-v1-update-questions"
               value="- [{"text":"this is updated first question", "options" : [ "test11", "test22", "test33", "test44"],"correctAnswer":"4"},{"text":"this is updated second question", "options" : [ "test111", "test222", "test333", "test444"], "correctAnswer":"1" }]"
               data-component="body">
    <br>
<p>array with some keys (objects) optional. The Question Sheets for the toolbox talk. Example: <code>- [{"text":"this is updated first question", "options" : [ "test11", "test22", "test33", "test44"],"correctAnswer":"4"},{"text":"this is updated second question", "options" : [ "test111", "test222", "test333", "test444"], "correctAnswer":"1" }]</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>attemptQuestions</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="attemptQuestions"                data-endpoint="POSTapi-v1-update-questions"
               value="17"
               data-component="body">
    <br>
<p>when we choose 'questions' the Question Sheets for the toolbox talk. In this Number of Questions to Ask per Participant(attemptQuestions) is always greater then Number of Correct Answers Required to Pass(number_of_correct_answer_to_pass). Example: <code>17</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>number_of_correct_answer_to_pass</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="number_of_correct_answer_to_pass"                data-endpoint="POSTapi-v1-update-questions"
               value="17"
               data-component="body">
    <br>
<p>when we choose 'questions' the Question Sheets for the toolbox talk. In this Number of Correct Answers Required to Pass(number_of_correct_answer_to_pass) is always less then Number of Questions to Ask per Participant(attemptQuestions). Example: <code>17</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>new_questions</code></b>&nbsp;&nbsp;
<small>json</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="new_questions"                data-endpoint="POSTapi-v1-update-questions"
               value="- [{"text":"this is new extra first question", "options" : [ "test11", "test22", "test33", "test44"],"correctAnswer":"4"},{"text":"this is new extra second question", "options" : [ "test111", "test222", "test333", "test444"], "correctAnswer":"1" }]"
               data-component="body">
    <br>
<p>array with some keys (objects) optional. The New Questions added for the toolbox talk. Example: <code>- [{"text":"this is new extra first question", "options" : [ "test11", "test22", "test33", "test44"],"correctAnswer":"4"},{"text":"this is new extra second question", "options" : [ "test111", "test222", "test333", "test444"], "correctAnswer":"1" }]</code></p>
        </div>
        </form>

                    <h2 id="endpoints-GETapi-v1-company-library-toolbox-talks">Retrieve all company library toolbox talks data which is saved into toolbox talk library.</h2>

<p>
</p>

<p>This endpoint returns all company library toolbox talks data. In this API, we get all company library toolbox talks data and also we can sorting through choosing Date created or Date updated from the dropdown list that toolbox tallk is created at what datetime or updated at what datetime. We can do search from the company library toolbox talks.</p>

<span id="example-requests-GETapi-v1-company-library-toolbox-talks">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "https://companymanagementsystems-back-qa.chetu.com/api/v1/company-library-toolbox-talks?no=consequatur" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://companymanagementsystems-back-qa.chetu.com/api/v1/company-library-toolbox-talks"
);

const params = {
    "no": "consequatur",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-company-library-toolbox-talks">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
     &quot;status&quot;: 200,
     &quot;message&quot;: &quot;Company Toolbox Talks Talks fetched successfully.&quot;,
      &quot;toolboxTalks&quot;: {
          &quot;data&quot;: [
              {
                  &quot;id&quot;: 8,
                  &quot;title&quot;: &quot;Test new again&quot;,
                  &quot;video_url&quot;: null,
                  &quot;number_of_questions_to_ask&quot;: null,
                  &quot;number_of_correct_answer_to_pass&quot;: null,
                  &quot;file&quot;: null,
                  &quot;description&quot;: &quot;&quot;,
                  &quot;user_id&quot;: 4392,
                  &quot;is_library&quot;: &quot;3&quot;,
                  &quot;is_library_deleted&quot;: &quot;2&quot;,
                  &quot;due_date&quot;: &quot;2025-08-27&quot;,
                  &quot;deleted_at&quot;: null,
                  &quot;status&quot;: &quot;1&quot;,
                  &quot;is_created&quot;: &quot;1&quot;,
                  &quot;created_at&quot;: &quot;2025-08-27T14:35:44.000000Z&quot;,
                  &quot;updated_at&quot;: &quot;2025-08-27T14:35:52.000000Z&quot;,
                  &quot;get_assigned_users_count&quot;: 5,
                  &quot;get_count_completed_count&quot;: 0
              },
              {
                  &quot;id&quot;: 7,
                  &quot;title&quot;: &quot;Testing new &quot;,
                  &quot;video_url&quot;: null,
                  &quot;number_of_questions_to_ask&quot;: null,
                  &quot;number_of_correct_answer_to_pass&quot;: null,
                  &quot;file&quot;: null,
                  &quot;description&quot;: &quot;&quot;,
                  &quot;user_id&quot;: 4392,
                  &quot;is_library&quot;: &quot;3&quot;,
                  &quot;is_library_deleted&quot;: &quot;2&quot;,
                  &quot;due_date&quot;: &quot;2025-08-27&quot;,
                  &quot;deleted_at&quot;: null,
                  &quot;status&quot;: &quot;1&quot;,
                  &quot;is_created&quot;: &quot;1&quot;,
                  &quot;created_at&quot;: &quot;2025-08-27T14:34:51.000000Z&quot;,
                  &quot;updated_at&quot;: &quot;2025-08-27T14:34:55.000000Z&quot;,
                  &quot;get_assigned_users_count&quot;: 1,
                  &quot;get_count_completed_count&quot;: 0
              },
          ],
          &quot;links&quot;: {&quot;first&quot;: &quot;https://companymanagementsystems-back-qa.chetu.com/api/v1/createdByMe-talks?page=1&quot;, &quot;last&quot;: &quot;https://companymanagementsystems-back-qa.chetu.com/api/v1/createdByMe-talks?page=1&quot;, &quot;prev&quot;: null,&quot;next&quot;: null},
          &quot;meta&quot;: { &quot;current_page&quot;: 1, &quot;from&quot;: 1, &quot;last_page&quot;: 1,
          &quot;links&quot;: [{&quot;url&quot;: null, &quot;label&quot;: &quot;&amp;laquo; Previous&quot;, &quot;active&quot;: false}, {&quot;url&quot;: &quot;https://companymanagementsystems-back-qa.chetu.com/api/v1/createdByMe-talks?page=1&quot;,&quot;label&quot;: &quot;1&quot;,&quot;active&quot;: true}, { &quot;url&quot;: null, &quot;label&quot;: &quot;Next &amp;raquo;&quot;, &quot;active&quot;: false }],
          &quot;path&quot;: &quot;https://companymanagementsystems-back-qa.chetu.com/api/v1/createdByMe-talks&quot;, &quot;per_page&quot;: 10, &quot;to&quot;: 8, &quot;total&quot;: 8 }
      }</code>
 </pre>
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;error&quot;: &quot;Data not found.&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (500):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;error&quot;: &quot;Failed to fetched toolbox talks: Something went wrong!&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-company-library-toolbox-talks" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-company-library-toolbox-talks"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-company-library-toolbox-talks"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-company-library-toolbox-talks" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-company-library-toolbox-talks">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-company-library-toolbox-talks" data-method="GET"
      data-path="api/v1/company-library-toolbox-talks"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-company-library-toolbox-talks', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-company-library-toolbox-talks"
                    onclick="tryItOut('GETapi-v1-company-library-toolbox-talks');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-company-library-toolbox-talks"
                    onclick="cancelTryOut('GETapi-v1-company-library-toolbox-talks');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-company-library-toolbox-talks"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/company-library-toolbox-talks</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-company-library-toolbox-talks"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-company-library-toolbox-talks"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>no</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="no"                data-endpoint="GETapi-v1-company-library-toolbox-talks"
               value="consequatur"
               data-component="query">
    <br>
<p>need of any param at initial. If we want to search or sorting any library toolbox talks then we need to put query params while we are searching then we need to put 'search_cms' &amp; for sorting according to the dates we need to put the updated_date or created_date in param. Example: <code>consequatur</code></p>
            </div>
                </form>

                    <h2 id="endpoints-POSTapi-v1-attempt-questions">Attempt the questions sheet with correct answer of a toolbox talk.</h2>

<p>
</p>

<p>This endpoint attempts the question sheet with correct answer of a toolbox talk. In this API, while we are attempting the question sheet with correct answer of a toolbox talk, we need to send toolbox_talk_id, questions in json array with some keys (objects) with the question ID you want to attempt and any answer ID which one you want to choose answer.</p>

<span id="example-requests-POSTapi-v1-attempt-questions">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "https://companymanagementsystems-back-qa.chetu.com/api/v1/attempt-questions" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"toolbox_talk_id\": \"consequatur\",
    \"questions\": \"- [{ \\\"question_id\\\": 2, \\\"answer\\\": 7 },{ \\\"question_id\\\": 1, \\\"answer\\\": 2 }]\",
    \"auth_user_id\": 17
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://companymanagementsystems-back-qa.chetu.com/api/v1/attempt-questions"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "toolbox_talk_id": "consequatur",
    "questions": "- [{ \"question_id\": 2, \"answer\": 7 },{ \"question_id\": 1, \"answer\": 2 }]",
    "auth_user_id": 17
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-attempt-questions">
            <blockquote>
            <p>Example response (201):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Questions attempted successfully.&quot;,
    &quot;data&quot;: [
        {
            &quot;id&quot;: 1,
            &quot;user_id&quot;: &quot;4392&quot;,
            &quot;question_id&quot;: 1,
            &quot;toolbox_talk_id&quot;: &quot;2&quot;,
            &quot;answer&quot;: 3,
            &quot;is_correct&quot;: 1,
            &quot;attempt_count&quot;: 1,
            &quot;result_data_count&quot;: {
                &quot;total_questions&quot;: 2,
                &quot;number_of_attempted&quot;: 2,
                &quot;number_of_passed&quot;: 1
            }
        }
    ],
    &quot;result&quot;: {
        &quot;correct_count&quot;: 1,
        &quot;status&quot;: &quot;passed&quot;
    }
}</code>
 </pre>
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;error&quot;: &quot;Question not found for ID.&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (422):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
 &quot;error&quot;: {
     &quot;toolbox_talk_id&quot;: [&quot;The toolbox_talk_id field is required.&quot;],
 }
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-v1-attempt-questions" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-attempt-questions"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-attempt-questions"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-attempt-questions" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-attempt-questions">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-attempt-questions" data-method="POST"
      data-path="api/v1/attempt-questions"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-attempt-questions', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-attempt-questions"
                    onclick="tryItOut('POSTapi-v1-attempt-questions');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-attempt-questions"
                    onclick="cancelTryOut('POSTapi-v1-attempt-questions');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-attempt-questions"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/attempt-questions</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v1-attempt-questions"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-v1-attempt-questions"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>toolbox_talk_id</code></b>&nbsp;&nbsp;
<small>interger</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="toolbox_talk_id"                data-endpoint="POSTapi-v1-attempt-questions"
               value="consequatur"
               data-component="body">
    <br>
<p>required. The toolbox_talk_id of the toolbox talk. Example: <code>consequatur</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>questions</code></b>&nbsp;&nbsp;
<small>json</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="questions"                data-endpoint="POSTapi-v1-attempt-questions"
               value="- [{ "question_id": 2, "answer": 7 },{ "question_id": 1, "answer": 2 }]"
               data-component="body">
    <br>
<p>array with some keys (objects) required. The Question Id's and Options ID's for the toolbox talk. Example: <code>- [{ "question_id": 2, "answer": 7 },{ "question_id": 1, "answer": 2 }]</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>auth_user_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="number" style="display: none"
               step="any"               name="auth_user_id"                data-endpoint="POSTapi-v1-attempt-questions"
               value="17"
               data-component="body">
    <br>
<p>optional. This is authentication user ID who is attempting the Question Sheet. Example: <code>17</code></p>
        </div>
        </form>

                    <h2 id="endpoints-POSTapi-v1-update-new-assigned-toolbox">Make a toolbox talk assigned to users.</h2>

<p>
</p>

<p>This endpoint do assign a toolbox to users. In this API, when we assign a toolbox talk then we need to choose one option from dropdown 'Send', 'Save in library' OR 'Send &amp; Save'. If we choose 'Send' OR 'Send &amp; Save' then we always need to select any role or departments or attendees or permissions and also 'Video URL Link' OR 'Upload PDF file' if attachment not uploaded at creating time of toolbox talk. And if we choose only Save in Library then it is showing as it is when this toolbox talk was created unassigned within 'create by me' tab and 'toolbox library within Company library'.</p>

<span id="example-requests-POSTapi-v1-update-new-assigned-toolbox">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "https://companymanagementsystems-back-qa.chetu.com/api/v1/update-new-assigned-toolbox" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"toolbox_talk_id\": \"consequatur\",
    \"select_user_detail\": \"- [{\\\"select_user_id\\\":\\\"4392\\\", \\\"user_name\\\":\\\"testing_name1\\\", \\\"user_email\\\":\\\"tpurposely@gmail.com\\\"}, {\\\"select_user_id\\\":\\\"4392\\\", \\\"user_name\\\":\\\"testing_name2\\\", \\\"user_email\\\":\\\"tpurposely1@yopmail.com\\\"}]\",
    \"due_date\": \"consequatur\",
    \"isLibrary\": 0
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://companymanagementsystems-back-qa.chetu.com/api/v1/update-new-assigned-toolbox"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "toolbox_talk_id": "consequatur",
    "select_user_detail": "- [{\"select_user_id\":\"4392\", \"user_name\":\"testing_name1\", \"user_email\":\"tpurposely@gmail.com\"}, {\"select_user_id\":\"4392\", \"user_name\":\"testing_name2\", \"user_email\":\"tpurposely1@yopmail.com\"}]",
    "due_date": "consequatur",
    "isLibrary": 0
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-update-new-assigned-toolbox">
            <blockquote>
            <p>Example response (201):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
 &quot;msg&quot;: &quot;Toolbox talk has been assigned successfully&quot;,
}</code>
 </pre>
            <blockquote>
            <p>Example response (422):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
 &quot;error&quot;: {
     &quot;toolbox_talk_id&quot;: [&quot;The toolbox_talk_id field is required.&quot;],
 }
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-v1-update-new-assigned-toolbox" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-update-new-assigned-toolbox"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-update-new-assigned-toolbox"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-update-new-assigned-toolbox" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-update-new-assigned-toolbox">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-update-new-assigned-toolbox" data-method="POST"
      data-path="api/v1/update-new-assigned-toolbox"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-update-new-assigned-toolbox', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-update-new-assigned-toolbox"
                    onclick="tryItOut('POSTapi-v1-update-new-assigned-toolbox');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-update-new-assigned-toolbox"
                    onclick="cancelTryOut('POSTapi-v1-update-new-assigned-toolbox');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-update-new-assigned-toolbox"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/update-new-assigned-toolbox</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v1-update-new-assigned-toolbox"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-v1-update-new-assigned-toolbox"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>toolbox_talk_id</code></b>&nbsp;&nbsp;
<small>interger</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="toolbox_talk_id"                data-endpoint="POSTapi-v1-update-new-assigned-toolbox"
               value="consequatur"
               data-component="body">
    <br>
<p>required. The toolbox_talk_id of the toolbox talk. Example: <code>consequatur</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>select_user_detail</code></b>&nbsp;&nbsp;
<small>json</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="select_user_detail"                data-endpoint="POSTapi-v1-update-new-assigned-toolbox"
               value="- [{"select_user_id":"4392", "user_name":"testing_name1", "user_email":"tpurposely@gmail.com"}, {"select_user_id":"4392", "user_name":"testing_name2", "user_email":"tpurposely1@yopmail.com"}]"
               data-component="body">
    <br>
<p>array with some keys (objects). The users selected from dropdown list from attendees or roles or departments or permissions or select users. It is required while choose 'Send' OR 'Send &amp; Save'. But when we choose 'Save in library' then this param is optional. Example: <code>- [{"select_user_id":"4392", "user_name":"testing_name1", "user_email":"tpurposely@gmail.com"}, {"select_user_id":"4392", "user_name":"testing_name2", "user_email":"tpurposely1@yopmail.com"}]</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>due_date</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="due_date"                data-endpoint="POSTapi-v1-update-new-assigned-toolbox"
               value="consequatur"
               data-component="body">
    <br>
<p>optional The Due date of toolbox talk. Ex:- &quot;2025-08-22&quot; Example: <code>consequatur</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>isLibrary</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="isLibrary"                data-endpoint="POSTapi-v1-update-new-assigned-toolbox"
               value="0"
               data-component="body">
    <br>
<p>when we select options from dropdown list then we send the values in this params 1, 2 or 3. Example: <code>0</code></p>
        </div>
        </form>

                    <h2 id="endpoints-POSTapi-v1-assignedtome">Get details of an assigned toolbox talk by toolbox_talk_id which is assigned to me (asigned to authentication user AUTH user).</h2>

<p>
</p>

<p>This endpoint returns detailed information about a assigned toolbox talk when their ID is provided as a query parameter. This API is providing the details of a single assigned toolbox talk which have all data of questions sheet with options and correct answers and also fetching the data of documents like video URL links or PDF's data. Now if we are getting the data of assigned users then this toolbox is already assigned to some users or whatever we are getting data of this user in below response &amp; apart from this we are getting details of that user also who has created this Toolbox talk.</p>

<span id="example-requests-POSTapi-v1-assignedtome">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "https://companymanagementsystems-back-qa.chetu.com/api/v1/assignedtome" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"toolbox_talk_id\": 17
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://companymanagementsystems-back-qa.chetu.com/api/v1/assignedtome"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "toolbox_talk_id": 17
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-assignedtome">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
      &quot;status&quot;: 200,
      &quot;msg&quot;: &quot;Successfully fetched Toolbox Talks that are assigned to you.&quot;,
      &quot;assignToMeToolboxTalks&quot;: {
         &quot;id&quot;: 58,
         &quot;title&quot;: &quot;new fresh test1&quot;,
         &quot;number_of_questions_to_ask&quot;: 1,
         &quot;number_of_correct_answer_to_pass&quot;: 1,
         &quot;description&quot;: &quot;This talk covers essential safety measures when working at heights, including the use of protective equipment, proper setup of ladders and scaffolding, and awareness of potential fall hazards.&quot;,
         &quot;user_id&quot;: 4392,
         &quot;is_library&quot;: &quot;2&quot;,
          &quot;due_date&quot;: &quot;2025-08-26&quot;,
          &quot;deleted_at&quot;: null,
          &quot;status&quot;: &quot;1&quot;,
          &quot;created_at&quot;: &quot;2025-08-26T10:54:33.000000Z&quot;,
          &quot;updated_at&quot;: &quot;2025-08-26T10:54:37.000000Z&quot;,
          &quot;questions&quot;: [{ &quot;id&quot;: 167, &quot;name&quot;: &quot;this is first question&quot;, &quot;options&quot;: [{&quot;id&quot;: 665, &quot;name&quot;: &quot;test1&quot;}, {&quot;id&quot;: 666,&quot;name&quot;: &quot;test2&quot;},{&quot;id&quot;: 667,&quot;name&quot;: &quot;test3&quot;},{&quot;id&quot;: 668,&quot;name&quot;: &quot;test4&quot;}], &quot;correct_answer&quot;: [{&quot;id&quot;: 665,&quot;name&quot;: &quot;test1&quot;}]},{ &quot;id&quot;: 167, &quot;name&quot;: &quot;this is second question&quot;, &quot;options&quot;: [{&quot;id&quot;: 770, &quot;name&quot;: &quot;A&quot;}, {&quot;id&quot;: 771,&quot;name&quot;: &quot;B&quot;},{&quot;id&quot;: 772,&quot;name&quot;: &quot;C&quot;},{&quot;id&quot;: 773,&quot;name&quot;: &quot;D&quot;}], &quot;correct_answer&quot;: [{&quot;id&quot;: 772,&quot;name&quot;: &quot;C&quot;}]}],
         &quot;video_url&quot;: [],
          &quot;file_data&quot;: [{&quot;id&quot;: 49,&quot;toolbox_talk_id&quot;: 58,&quot;file_url&quot;: &quot;https://companymanagementsystems-back-qa.chetu.com/storage/toolbox_talks/toolbox_talk_58311756205673.pdf&quot;, &quot;file_name&quot;: &quot;toolbox_talk_58311756205673.pdf&quot;,&quot;file_status&quot;: &quot;1&quot;, &quot;file_state&quot;: &quot;Completed&quot;}],
      },

}</code>
 </pre>
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;error&quot;: &quot;Assigned toolbox talk data not found&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-v1-assignedtome" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-assignedtome"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-assignedtome"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-assignedtome" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-assignedtome">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-assignedtome" data-method="POST"
      data-path="api/v1/assignedtome"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-assignedtome', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-assignedtome"
                    onclick="tryItOut('POSTapi-v1-assignedtome');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-assignedtome"
                    onclick="cancelTryOut('POSTapi-v1-assignedtome');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-assignedtome"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/assignedtome</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v1-assignedtome"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-v1-assignedtome"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>toolbox_talk_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="toolbox_talk_id"                data-endpoint="POSTapi-v1-assignedtome"
               value="17"
               data-component="body">
    <br>
<p>The toolbox_talk_id of the toolbox talk. Example: <code>17</code></p>
        </div>
        </form>

                    <h2 id="endpoints-GETapi-v1-delete-question--id-">Delete a single question from question sheet of a toolbox talk by ID.</h2>

<p>
</p>

<p>This endpoint deletes a single question from question sheet of a toolbox talk by ID is provided as a query parameter. This API deletes a question from the questions sheet of a particular toolbox talk. We provide the question id into the param for deleting a questioon from the question sheet.</p>

<span id="example-requests-GETapi-v1-delete-question--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "https://companymanagementsystems-back-qa.chetu.com/api/v1/delete-question/consequatur?id=17" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://companymanagementsystems-back-qa.chetu.com/api/v1/delete-question/consequatur"
);

const params = {
    "id": "17",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-delete-question--id-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Question is deleted successfully!&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;error&quot;: &quot;Question ID data not found&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-delete-question--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-delete-question--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-delete-question--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-delete-question--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-delete-question--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-delete-question--id-" data-method="GET"
      data-path="api/v1/delete-question/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-delete-question--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-delete-question--id-"
                    onclick="tryItOut('GETapi-v1-delete-question--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-delete-question--id-"
                    onclick="cancelTryOut('GETapi-v1-delete-question--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-delete-question--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/delete-question/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-delete-question--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-delete-question--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="id"                data-endpoint="GETapi-v1-delete-question--id-"
               value="consequatur"
               data-component="url">
    <br>
<p>The ID of the delete question. Example: <code>consequatur</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="GETapi-v1-delete-question--id-"
               value="17"
               data-component="query">
    <br>
<p>The question ID of a questions sheet of a toolbox talk. Example: <code>17</code></p>
            </div>
                </form>

                    <h2 id="endpoints-POSTapi-v1-delete-selected-cms-library">Delete a toolbox talk by toolbox_talk_id into array.</h2>

<p>
</p>

<p>This endpoint deletes a toolbox talk specified by its IDs in the request body in an array. In this API we can delete multiple toolbox talks together or we can delete only single at a time.</p>

<span id="example-requests-POSTapi-v1-delete-selected-cms-library">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "https://companymanagementsystems-back-qa.chetu.com/api/v1/delete-selected-cms-library" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"toolbox_talk_id\": 17
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://companymanagementsystems-back-qa.chetu.com/api/v1/delete-selected-cms-library"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "toolbox_talk_id": 17
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-delete-selected-cms-library">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Toolbox talk library is deleted successfully!&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;error&quot;: &quot;Data not found.&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (500):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;error&quot;: &quot;Failed to delete toolbox talks library: Something went wrong!&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-v1-delete-selected-cms-library" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-delete-selected-cms-library"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-delete-selected-cms-library"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-delete-selected-cms-library" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-delete-selected-cms-library">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-delete-selected-cms-library" data-method="POST"
      data-path="api/v1/delete-selected-cms-library"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-delete-selected-cms-library', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-delete-selected-cms-library"
                    onclick="tryItOut('POSTapi-v1-delete-selected-cms-library');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-delete-selected-cms-library"
                    onclick="cancelTryOut('POSTapi-v1-delete-selected-cms-library');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-delete-selected-cms-library"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/delete-selected-cms-library</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v1-delete-selected-cms-library"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-v1-delete-selected-cms-library"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>toolbox_talk_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="number" style="display: none"
               step="any"               name="toolbox_talk_id"                data-endpoint="POSTapi-v1-delete-selected-cms-library"
               value="17"
               data-component="body">
    <br>
<p>array required The toolbox_talk_id of the toolbox talks to delete. Example: <code>17</code></p>
        </div>
        </form>

                    <h2 id="endpoints-POSTapi-v1-update-video-pdf-status">Update the video status OR PDF status of a toolbox talk.</h2>

<p>
</p>

<p>This endpoint updates the video status OR PDF status of a toolbox talk. In this API, while we are updating the video status OR PDF status of a toolbox talk, we need to send 'video_id' OR 'file_id' and 'type' param to differentiate that we are updating PDF status or video status &amp; also send the value of 'status' means video is watched or not &amp; at other hand, PDF is read or not.</p>

<span id="example-requests-POSTapi-v1-update-video-pdf-status">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "https://companymanagementsystems-back-qa.chetu.com/api/v1/update-video-pdf-status" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"toolbox_talk_id\": 17,
    \"type\": \"Video\",
    \"status\": \"1\",
    \"\'toolbox_talk_id\'\": 17,
    \"\'video_id\'\": \"consequatur\",
    \"\'file_id\'\": \"consequatur\",
    \"\'type\'\": \"consequatur\",
    \"\'status\'\": \"consequatur\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://companymanagementsystems-back-qa.chetu.com/api/v1/update-video-pdf-status"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "toolbox_talk_id": 17,
    "type": "Video",
    "status": "1",
    "'toolbox_talk_id'": 17,
    "'video_id'": "consequatur",
    "'file_id'": "consequatur",
    "'type'": "consequatur",
    "'status'": "consequatur"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-update-video-pdf-status">
            <blockquote>
            <p>Example response (201):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
 &quot;status&quot;: 200,
 &quot;message&quot;: &quot;Attachments updated successfully&quot;,
 &quot;data&quot;: {
         &quot;id&quot;: 1,
  &quot;user_id&quot;: 4392,
  &quot;toolbox_talk_id&quot;: 1,
  &quot;video_url&quot;: &quot;https://static.vecteezy.com/system/resources/previews/008/259/475/mp4/wooden-dummy-training-in-wing-chun-kung-fu-a-man-practicing-wing-chun-video.mp4&quot;,
  &quot;video_description&quot;: null,
  &quot;video_status&quot;: &quot;1&quot;,
  &quot;video_state&quot;: &quot;Completed&quot;,
  &quot;deleted_at&quot;: null,
  &quot;created_at&quot;: &quot;2025-08-26T17:22:40.000000Z&quot;,
  &quot;updated_at&quot;: &quot;2025-08-27T18:05:08.000000Z&quot;
      }
  &quot;msg&quot;: &quot;Video has been completed successfully!&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (422):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
 &quot;error&quot;: {
     &quot;toolbox_talk_id&quot;: [&quot;The toolbox_talk_id field is required.&quot;],
 }
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-v1-update-video-pdf-status" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-update-video-pdf-status"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-update-video-pdf-status"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-update-video-pdf-status" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-update-video-pdf-status">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-update-video-pdf-status" data-method="POST"
      data-path="api/v1/update-video-pdf-status"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-update-video-pdf-status', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-update-video-pdf-status"
                    onclick="tryItOut('POSTapi-v1-update-video-pdf-status');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-update-video-pdf-status"
                    onclick="cancelTryOut('POSTapi-v1-update-video-pdf-status');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-update-video-pdf-status"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/update-video-pdf-status</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v1-update-video-pdf-status"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-v1-update-video-pdf-status"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>toolbox_talk_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="toolbox_talk_id"                data-endpoint="POSTapi-v1-update-video-pdf-status"
               value="17"
               data-component="body">
    <br>
<p>Example: <code>17</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>video_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="video_id"                data-endpoint="POSTapi-v1-update-video-pdf-status"
               value=""
               data-component="body">
    <br>
<p>This field is required when <code>file_id</code> is not present. The <code>id</code> of an existing record in the resource_video_links table.</p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>file_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="file_id"                data-endpoint="POSTapi-v1-update-video-pdf-status"
               value=""
               data-component="body">
    <br>
<p>This field is required when <code>video_id</code> is not present. The <code>id</code> of an existing record in the media_files table.</p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>type</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="type"                data-endpoint="POSTapi-v1-update-video-pdf-status"
               value="Video"
               data-component="body">
    <br>
<p>Example: <code>Video</code></p>
Must be one of:
<ul style="list-style-type: square;"><li><code>Video</code></li> <li><code>Pdf</code></li></ul>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>status</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="status"                data-endpoint="POSTapi-v1-update-video-pdf-status"
               value="1"
               data-component="body">
    <br>
<p>Example: <code>1</code></p>
Must be one of:
<ul style="list-style-type: square;"><li><code>1</code></li> <li><code>2</code></li></ul>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>&#039;toolbox_talk_id&#039;</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="&#039;toolbox_talk_id&#039;"                data-endpoint="POSTapi-v1-update-video-pdf-status"
               value="17"
               data-component="body">
    <br>
<p>The toolbox_talk_id of the toolbox talk. Example: <code>17</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>&#039;video_id&#039;</code></b>&nbsp;&nbsp;
<small>interger</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="&#039;video_id&#039;"                data-endpoint="POSTapi-v1-update-video-pdf-status"
               value="consequatur"
               data-component="body">
    <br>
<p>while 'file_id' is not available. The video id of the toolbox talk. Example: <code>consequatur</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>&#039;file_id&#039;</code></b>&nbsp;&nbsp;
<small>interger</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="&#039;file_id&#039;"                data-endpoint="POSTapi-v1-update-video-pdf-status"
               value="consequatur"
               data-component="body">
    <br>
<p>while 'video_id' is not available. The File id of the toolbox talk. Example: <code>consequatur</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>&#039;type&#039;</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="&#039;type&#039;"                data-endpoint="POSTapi-v1-update-video-pdf-status"
               value="consequatur"
               data-component="body">
    <br>
<p>required. The 'type' to differentiate the PDF or Video of the toolbox talk. Example: <code>consequatur</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>&#039;status&#039;</code></b>&nbsp;&nbsp;
<small>interger</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="&#039;status&#039;"                data-endpoint="POSTapi-v1-update-video-pdf-status"
               value="consequatur"
               data-component="body">
    <br>
<p>required. Status of video has been watched or not, same for PDF is read or not of a toolbox talk. Example: <code>consequatur</code></p>
        </div>
        </form>

                    <h2 id="endpoints-POSTapi-v1-get-questions-options">Get details of questions with their options by toolbox_talk_id.</h2>

<p>
</p>

<p>This endpoint returns details of questions with their options of a toolbox talk when their ID is provided as a body parameter. This API is providing the details of all questions with thier options for a particular toolbox talk which have all data of questions sheet with options.</p>

<span id="example-requests-POSTapi-v1-get-questions-options">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "https://companymanagementsystems-back-qa.chetu.com/api/v1/get-questions-options" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"toolbox_talk_id\": 17
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://companymanagementsystems-back-qa.chetu.com/api/v1/get-questions-options"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "toolbox_talk_id": 17
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-get-questions-options">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
      &quot;msg&quot;: &quot;Toolbox Talks questions and options data has been fetched successfully.&quot;,
      &quot;data&quot;: {
         &quot;id&quot;: 58,
         &quot;title&quot;: &quot;new fresh test1&quot;,
         &quot;number_of_questions_to_ask&quot;: 1,
         &quot;number_of_correct_answer_to_pass&quot;: 1,
         &quot;description&quot;: &quot;This talk covers essential safety measures when working at heights, including the use of protective equipment, proper setup of ladders and scaffolding, and awareness of potential fall hazards.&quot;,
         &quot;user_id&quot;: 4392,
         &quot;is_library&quot;: &quot;2&quot;,
          &quot;questions&quot;: [{ &quot;id&quot;: 167, &quot;name&quot;: &quot;this is first question&quot;, &quot;options&quot;: [{&quot;id&quot;: 665, &quot;name&quot;: &quot;test1&quot;}, {&quot;id&quot;: 666,&quot;name&quot;: &quot;test2&quot;},{&quot;id&quot;: 667,&quot;name&quot;: &quot;test3&quot;},{&quot;id&quot;: 668,&quot;name&quot;: &quot;test4&quot;}],{ &quot;id&quot;: 167, &quot;name&quot;: &quot;this is second question&quot;, &quot;options&quot;: [{&quot;id&quot;: 770, &quot;name&quot;: &quot;A&quot;}, {&quot;id&quot;: 771,&quot;name&quot;: &quot;B&quot;},{&quot;id&quot;: 772,&quot;name&quot;: &quot;C&quot;},{&quot;id&quot;: 773,&quot;name&quot;: &quot;D&quot;}]}],
      },

}</code>
 </pre>
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;error&quot;: &quot;Questions with options of a toolbox talk data not found&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-v1-get-questions-options" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-get-questions-options"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-get-questions-options"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-get-questions-options" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-get-questions-options">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-get-questions-options" data-method="POST"
      data-path="api/v1/get-questions-options"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-get-questions-options', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-get-questions-options"
                    onclick="tryItOut('POSTapi-v1-get-questions-options');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-get-questions-options"
                    onclick="cancelTryOut('POSTapi-v1-get-questions-options');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-get-questions-options"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/get-questions-options</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v1-get-questions-options"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-v1-get-questions-options"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>toolbox_talk_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="toolbox_talk_id"                data-endpoint="POSTapi-v1-get-questions-options"
               value="17"
               data-component="body">
    <br>
<p>The toolbox_talk_id of the toolbox talk. Example: <code>17</code></p>
        </div>
        </form>

                    <h2 id="endpoints-POSTapi-v1-video-pdf-status">Get video OR PDF status detail after watched or read by toolbox_talk_id.</h2>

<p>
</p>

<p>This endpoint returns details of video OR PDf status(updated status) of a toolbox talk when their ID is provided as a body parameter. This API is providing the details of status of Video OR PDF.</p>

<span id="example-requests-POSTapi-v1-video-pdf-status">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "https://companymanagementsystems-back-qa.chetu.com/api/v1/video-pdf-status" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"toolbox_talk_id\": 17
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://companymanagementsystems-back-qa.chetu.com/api/v1/video-pdf-status"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "toolbox_talk_id": 17
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-video-pdf-status">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
 {
     &quot;status&quot;: 200,
     &quot;vorfstatus&quot;: 3
 }

}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-v1-video-pdf-status" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-video-pdf-status"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-video-pdf-status"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-video-pdf-status" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-video-pdf-status">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-video-pdf-status" data-method="POST"
      data-path="api/v1/video-pdf-status"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-video-pdf-status', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-video-pdf-status"
                    onclick="tryItOut('POSTapi-v1-video-pdf-status');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-video-pdf-status"
                    onclick="cancelTryOut('POSTapi-v1-video-pdf-status');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-video-pdf-status"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/video-pdf-status</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v1-video-pdf-status"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-v1-video-pdf-status"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>toolbox_talk_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="toolbox_talk_id"                data-endpoint="POSTapi-v1-video-pdf-status"
               value="17"
               data-component="body">
    <br>
<p>The toolbox_talk_id of the toolbox talk. Example: <code>17</code></p>
        </div>
        </form>

                    <h2 id="endpoints-POSTapi-v1-acknowledged-status">Update the acknowledged status of a toolbox talk.</h2>

<p>
</p>

<p>This endpoint updates the acknowledged status of a toolbox talk. In this API, while we are updating the acknowledged status of a toolbox talk, we need to send 'status' value as 2. When any auth user watches any video through the video link or read the proper PDF then if question sheets are avilable of this toolbox talk, user need to attempt the exam or attempt the questions if he passed then he can acknowledged for this particular toolbox talk. If he failed then he need to attempt again &amp; again, until he does not pass.</p>

<span id="example-requests-POSTapi-v1-acknowledged-status">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "https://companymanagementsystems-back-qa.chetu.com/api/v1/acknowledged-status" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"toolbox_talk_id\": 17,
    \"\'toolbox_talk_id\'\": 17
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://companymanagementsystems-back-qa.chetu.com/api/v1/acknowledged-status"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "toolbox_talk_id": 17,
    "'toolbox_talk_id'": 17
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-acknowledged-status">
            <blockquote>
            <p>Example response (201):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
 &quot;message&quot;: &quot;AssignToolBox acknowledged successfully!&quot;,
}</code>
 </pre>
            <blockquote>
            <p>Example response (422):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
 &quot;error&quot;: {
     &quot;toolbox_talk_id&quot;: [&quot;The toolbox_talk_id field is required.&quot;],
 }
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-v1-acknowledged-status" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-acknowledged-status"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-acknowledged-status"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-acknowledged-status" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-acknowledged-status">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-acknowledged-status" data-method="POST"
      data-path="api/v1/acknowledged-status"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-acknowledged-status', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-acknowledged-status"
                    onclick="tryItOut('POSTapi-v1-acknowledged-status');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-acknowledged-status"
                    onclick="cancelTryOut('POSTapi-v1-acknowledged-status');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-acknowledged-status"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/acknowledged-status</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v1-acknowledged-status"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-v1-acknowledged-status"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>toolbox_talk_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="toolbox_talk_id"                data-endpoint="POSTapi-v1-acknowledged-status"
               value="17"
               data-component="body">
    <br>
<p>Example: <code>17</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>&#039;toolbox_talk_id&#039;</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="&#039;toolbox_talk_id&#039;"                data-endpoint="POSTapi-v1-acknowledged-status"
               value="17"
               data-component="body">
    <br>
<p>The toolbox_talk_id of the toolbox talk. Example: <code>17</code></p>
        </div>
        </form>

                    <h2 id="endpoints-POSTapi-v1-make-toolbox-copy">Make a copy of a toolbox talk.</h2>

<p>
</p>

<p>This endpoint updates Make a copy of a toolbox talk. In this API, while we are making a copy of a toolbox talk. Using this API we can make a copy of a particular toolbox talk. We can generate multiple copies of a toolbox talk. After copy of the toolbox talk, whole data is copied as it is and we are able to assigned to some users.</p>

<span id="example-requests-POSTapi-v1-make-toolbox-copy">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "https://companymanagementsystems-back-qa.chetu.com/api/v1/make-toolbox-copy" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"toolbox_talk_id\": 17,
    \"\'toolbox_talk_id\'\": 17
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://companymanagementsystems-back-qa.chetu.com/api/v1/make-toolbox-copy"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "toolbox_talk_id": 17,
    "'toolbox_talk_id'": 17
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-make-toolbox-copy">
            <blockquote>
            <p>Example response (201):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
 &quot;msg&quot;: &quot;Toolbox Talk copy is created successfully&quot;,
}</code>
 </pre>
            <blockquote>
            <p>Example response (422):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
 &quot;error&quot;: {
     &quot;toolbox_talk_id&quot;: [&quot;The toolbox_talk_id field is required.&quot;],
 }
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-v1-make-toolbox-copy" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-make-toolbox-copy"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-make-toolbox-copy"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-make-toolbox-copy" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-make-toolbox-copy">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-make-toolbox-copy" data-method="POST"
      data-path="api/v1/make-toolbox-copy"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-make-toolbox-copy', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-make-toolbox-copy"
                    onclick="tryItOut('POSTapi-v1-make-toolbox-copy');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-make-toolbox-copy"
                    onclick="cancelTryOut('POSTapi-v1-make-toolbox-copy');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-make-toolbox-copy"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/make-toolbox-copy</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v1-make-toolbox-copy"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-v1-make-toolbox-copy"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>toolbox_talk_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="toolbox_talk_id"                data-endpoint="POSTapi-v1-make-toolbox-copy"
               value="17"
               data-component="body">
    <br>
<p>Example: <code>17</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>&#039;toolbox_talk_id&#039;</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="&#039;toolbox_talk_id&#039;"                data-endpoint="POSTapi-v1-make-toolbox-copy"
               value="17"
               data-component="body">
    <br>
<p>The toolbox_talk_id of the toolbox talk. Example: <code>17</code></p>
        </div>
        </form>

                    <h2 id="endpoints-POSTapi-v1-update-content-toolboxtalk">Update the title or description of a toolbox talk.</h2>

<p>
</p>

<p>This endpoint updates the title or description of a toolbox talk. In this API, while we are updating the title or description then title or desciption param will be send in API in bodyparam &amp; also send the toolbox talk ID.</p>

<span id="example-requests-POSTapi-v1-update-content-toolboxtalk">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "https://companymanagementsystems-back-qa.chetu.com/api/v1/update-content-toolboxtalk" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"toolbox_talk_id\": 17,
    \"\'toolbox_talk_id\'\": 17,
    \"\'title\'\": \"consequatur\",
    \"\'description\'\": \"consequatur\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://companymanagementsystems-back-qa.chetu.com/api/v1/update-content-toolboxtalk"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "toolbox_talk_id": 17,
    "'toolbox_talk_id'": 17,
    "'title'": "consequatur",
    "'description'": "consequatur"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-update-content-toolboxtalk">
            <blockquote>
            <p>Example response (201):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
 &quot;msg&quot;: &quot;Toolbox Talk content has been updated successfully&quot;,
}</code>
 </pre>
            <blockquote>
            <p>Example response (422):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
 &quot;error&quot;: {
     &quot;toolbox_talk_id&quot;: [&quot;The toolbox_talk_id field is required.&quot;],
 }
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-v1-update-content-toolboxtalk" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-update-content-toolboxtalk"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-update-content-toolboxtalk"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-update-content-toolboxtalk" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-update-content-toolboxtalk">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-update-content-toolboxtalk" data-method="POST"
      data-path="api/v1/update-content-toolboxtalk"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-update-content-toolboxtalk', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-update-content-toolboxtalk"
                    onclick="tryItOut('POSTapi-v1-update-content-toolboxtalk');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-update-content-toolboxtalk"
                    onclick="cancelTryOut('POSTapi-v1-update-content-toolboxtalk');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-update-content-toolboxtalk"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/update-content-toolboxtalk</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v1-update-content-toolboxtalk"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-v1-update-content-toolboxtalk"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>toolbox_talk_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="toolbox_talk_id"                data-endpoint="POSTapi-v1-update-content-toolboxtalk"
               value="17"
               data-component="body">
    <br>
<p>Example: <code>17</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>title</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="title"                data-endpoint="POSTapi-v1-update-content-toolboxtalk"
               value=""
               data-component="body">
    <br>
<p>This field is required when <code>description</code> is not present.</p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>description</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="description"                data-endpoint="POSTapi-v1-update-content-toolboxtalk"
               value=""
               data-component="body">
    <br>
<p>This field is required when <code>title</code> is not present.</p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>&#039;toolbox_talk_id&#039;</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="&#039;toolbox_talk_id&#039;"                data-endpoint="POSTapi-v1-update-content-toolboxtalk"
               value="17"
               data-component="body">
    <br>
<p>The toolbox_talk_id of the toolbox talk. Example: <code>17</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>&#039;title&#039;</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="&#039;title&#039;"                data-endpoint="POSTapi-v1-update-content-toolboxtalk"
               value="consequatur"
               data-component="body">
    <br>
<p>while 'description' is not available. The title of the toolbox talk. Example: <code>consequatur</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>&#039;description&#039;</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="&#039;description&#039;"                data-endpoint="POSTapi-v1-update-content-toolboxtalk"
               value="consequatur"
               data-component="body">
    <br>
<p>while 'title' is not availble. The description of the toolbox talk. Example: <code>consequatur</code></p>
        </div>
        </form>

                    <h2 id="endpoints-GETapi-v1-export_toolbox_csv--id-">Get the detailed data of signoff sheet with title data of a toolbox talk.</h2>

<p>
</p>

<p>This endpoint retrieves detailed data of signoff sheet with title data of a toolbox talk. In this API, while we are getting ata of signoff sheet with title data then we need to send only 'toolbox_talk_id' in queryParam.</p>

<span id="example-requests-GETapi-v1-export_toolbox_csv--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "https://companymanagementsystems-back-qa.chetu.com/api/v1/export_toolbox_csv/consequatur?%27toolbox_talk_id%27=17" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://companymanagementsystems-back-qa.chetu.com/api/v1/export_toolbox_csv/consequatur"
);

const params = {
    "'toolbox_talk_id'": "17",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-export_toolbox_csv--id-">
            <blockquote>
            <p>Example response (201):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{}</code>
 </pre>
            <blockquote>
            <p>Example response (422):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
 &quot;error&quot;: {
     &quot;toolbox_talk_id&quot;: [&quot;The toolbox_talk_id field is required.&quot;],
 }
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-export_toolbox_csv--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-export_toolbox_csv--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-export_toolbox_csv--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-export_toolbox_csv--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-export_toolbox_csv--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-export_toolbox_csv--id-" data-method="GET"
      data-path="api/v1/export_toolbox_csv/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-export_toolbox_csv--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-export_toolbox_csv--id-"
                    onclick="tryItOut('GETapi-v1-export_toolbox_csv--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-export_toolbox_csv--id-"
                    onclick="cancelTryOut('GETapi-v1-export_toolbox_csv--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-export_toolbox_csv--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/export_toolbox_csv/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-export_toolbox_csv--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-export_toolbox_csv--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="id"                data-endpoint="GETapi-v1-export_toolbox_csv--id-"
               value="consequatur"
               data-component="url">
    <br>
<p>The ID of the export toolbox csv. Example: <code>consequatur</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>&#039;toolbox_talk_id&#039;</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="&#039;toolbox_talk_id&#039;"                data-endpoint="GETapi-v1-export_toolbox_csv--id-"
               value="17"
               data-component="query">
    <br>
<p>The toolbox_talk_id of the toolbox talk. Example: <code>17</code></p>
            </div>
                </form>

            

        
    </div>
    <div class="dark-box">
                    <div class="lang-selector">
                                                        <button type="button" class="lang-button" data-language-name="bash">bash</button>
                                                        <button type="button" class="lang-button" data-language-name="javascript">javascript</button>
                            </div>
            </div>
</div>
</body>
</html>
