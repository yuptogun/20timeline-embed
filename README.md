# What this script is all about

이 php 스크립트는 특정 워드프레스 사이트의 게시물의 제목, 글쓴이, 요약과 기사 일부를 `post_id` 값에 따라 출력해 줍니다.
The script outputs the title, author, excerpt and some of the text contents in any article of the certain Wordpress website according to the `post_id`.

리퀘스트 pull 많이 넣어 주세요. 듣고 배우겠습니다.
Any request pull is welcomed. I love hearing from you guys and learn lessons.

# How to use

20timeline.com에 등록된 기사를 임베딩하기 위하여, 다음과 같이 `iframe` 형태로 사용합니다.
You can embed the article posted in 20timeline.com with the `iframe` code below

`<iframe src="http://20timeline.com/embed.php?id=1727" width="400" height="200" allowtransparency="true"></iframe>`

`id`에 입력한 숫자와 일치하는 `post_id`가 없을 경우 404 뷰가 출력됩니다.
If there's no article that has the `post_id` you input in `id`, it returns 404 view to you.

# How to reuse

당신의 워드프레스 사이트에서 이 스크립트를 재사용하려면 다음 순서대로 합니다.
Follow these steps to have this script working in your Wordpress website.

1. 클론합니다. Clone it.
2. php 스크립트 내 문자열, CSS 코드 등을 당신의 웹사이트에 맞게 적절히 수정합니다. Customize the strings in the php part and the CSS.
3. 당신의 `/wordpress` 폴더의 아무 데나 업로드합니다. 최상위 폴더를 추천합니다. Upload it to any directory in your `/wordpress` site(the root directory is recommended).
4. 업로드된 절대 경로로 `iframe` 코드를 작성합니다. Make your own `iframe` embedding code with the absolute path of your script.

- 현재 Wordpress의 **posts**만 지원하며, pages는 지원하지 않습니다. Currently, ihe 'id' parameter is only for the the post_id of the Wordpress **post**, not page.