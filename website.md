# 사람과교육 연구소 사이버스페이스

## 개요
사람과 교육 연구소의 웹 서비스를 웹 2.0의 특징으로 말하는 참여, 공유, 개방을 구현하여 플랫폼으로서의 웹, 집단지성의 활용, 지속가능한 서비스,사용자의 요구를 반영한 다양한 접속환경에 반응하는 반응형 서비스로 구현함에 있어 그 첫 단계로 개발의 범위를 규정하고 요청을 명확하게 하기 위하여 본 문서를 작성합니다.

## 요구사항
* 상단에 글쓰기 기능이 있어서 바로 글을 쓸수 있는 기능
* 페이스 북의 디자인과 유사하게 제작
* 자동 로그인기능
* 좌측 사용자 정의 카테고리 메뉴
* 우측 사람과교육 연구소 메뉴
* SNS 와 API 를 통한 연계
* 홈페이지가 아닌 추후 확장도 가능한 사용자들의 개인 공간을 할당해 줄 수 있는 프레임워크가 필요

## 요구사항 분석
### 상단에 글쓰기 기능이 있어서 바로 글을 쓸수 있는 기능
#### 요구사항 기능분해
*페이스북처럼 상단에 바로 글쓰기 기능이 있어 자유롭게 글을 쓸수 있다.
*글을 저장하기 전에 카테고리를 지정하고 글을 저장하도록 한다.
*모든 플랫폼에서 깔끔하게 글쓰기 기능이 지원 되어야 한다.
*글쓰기를 할때 사진,문서 첨부등 기능이 지원되어야한다.

#### 구현방안
GNU 보드에서 기본으로 지원하는 에디터를 사용하여 구현 테스트 를한다.

### 페이스 북의 디자인과 유사하게 제작
#### 요구사항 기능분해

*PC 용화면인 경우  3단으로 구현하고 중앙 부분은 메뉴와 별개로 스크롤 된다.
> 상단, 좌, 우측 메뉴를 스크롤되지 않도록 처리한다.

모바일 인 경우 Top 메뉴를 고정하고 좌측 우측 메뉴를 슬라이드 방식으로 평소에 숨어있다가 나올수 있도록 구현한다.

#### 구현 방안
*GNU 보드의 레이아웃을 사용하지 않고 신규로 제작한다. 
*웹에이전시를 지정하여 전문 퍼블리셔에게 의뢰하여 웹 호환성 및 접근성 을 확보하고 디자인 시안을 받아서 디자인을 결정한다.

### 자동 로그인기능
#### 요구사항  기능분해
*사용자의 선택에 의해서 접속시 개인의 자동 로그인을 지원한다.
*자동로그인은 페이스북과도 연동되어야 한다.

#### 구현방안
*GNU보드의 자동 로그인 기능을 사용한다.
*페이스북과 통신하는 것은 페이스북 API 를 사용하기 위하여 개인 계정에 페이스북의 토큰을 저장 한다.

### 좌측사용자 정의 카테고리 메뉴
#### 요구사항 기능분해
*사용자카테고리를 구현하기 위한 db설계 가 필요하다.
*카테고리 관리(등록,수정,삭제) 기능이 필요하다.
*카테고리 관리시 하위 글 처리를 위해 카테고리 간 글 이동을 지원 하여야 한다.
*카테고리 깊이와 갯수 제한필요하다.

#### 구현방안
*카테고리는 트리 자료구조로 구현한다.
*기능의 유연성을 확보하기 위하여 기존 보드의 게시판 분류나 메뉴 구조와는 별개로 구현한다.
*카테 고리 적용시 GNU보드의 게시판-카테고리 기능과 연계 가능 한지 여부를 확인할 필요가 있다.
*개인 정보유출등 보안 사고 예방을 위해 CRUD 작업시 보안 코딩 필요하다.
*카테고리 공유기능에 대하여 아래 사항등을 고민할 필요가 있다. 
    * 카테고리 공유 범위
    * 공유카테고리에 대한 권한 문제
    * 공유 대상 및 공유 대상 그룹 선택 방식 문제
    * 사용자 그룹의 필요성
*카테고리 깊이와 수에따른 디자인 변경및 자료구조 변경이 발생하므로 추후 확장성을 고려하여 결정해야 한다

### 우측 사람과교육 연구소 메뉴
#### 요구사항 기능분해
*기존 홈페이지의 메뉴를 트리형태로 우측에서 사용할 수 있도록 구성한다 .
*기존 홈페이지 메뉴 중 불필요한 부분을 통폐합하는등 정리가 필요하다.
*기존 홈페이지 데이터 마이그레이션 필요 (큰 의미가 없어도 홈페이지의 연속성을 인식 시켜주기 위해 필요함)하다.

#### 구현방안
*제로보드 GNU보드 마이그레이션 툴 사용하여 일 차적으로 처리한다.
*데이터 글 이동등 정리는 사용자가 기능을 통하여 실행한다.
*메뉴 관리 보드 추가 등 기능은 관리자 페이지를  커스터마이징 하여 구현 한다.
*관리자 페이지 커스터마이징시 스킨 등 불필요한 기능은 전부 제거하고 꼭 필요한 기능만 구현한다.
*커스터마이징중 기존 디비구조를 복제할지 그냥 사용할지 경정하여 개발한다.

### SNS 와 API 를 통한 연계
#### 요구사항 기능분해
*연구소 프레임워크에 쓴 글을 페이스 에도 공유가 되도록한다.
*페이스 북에 쓴 글을 연구소 프레임워크에 불러올수 있다.
*트위터,밴드,카카오스토리등 기타 SNS 와도 연계한다.

#### 구현방안
*페이스 북 API 를 활용하여 구현 가능한 부분을 확인한다.
*페이스북 계정과 사람과교육 연구소 계정간의 연동을 위하여 페이스북 인증 토큰을 계정 정보에 저장한다.
*토큰을 지원하기 위하여 O-Auth 구현할 필요가 있는지 확인한다.
*페이스북 의 글을 읽어오기위해 혹은 사람과교육 연구소의 글을 페이스 북으로 보내기 위하여 크롤러 데몬을 구현하여 활용하는 방안을 적극 검토한다.

### 홈페이지가 아닌 추후 확장도 가능한 사용자들의 개인 공간을 할당해 줄 수  있는 프레임워크가 필요
#### 요구사항 기능분해
*서비스를 개인화 하여 내가 쓴글만 내가 볼수 있다.
*내가 쓴 글을 퍼블리싱하여 다른 사람이 볼수 있더록 할수 있다.
*다른 사람이 퍼블리싱한 글들 전체를 타임라인으로 볼수 있도록 하고 이 타임라인을 첫 페이지로 지정한다.
*퍼블리싱을 기본값으로 하여 공유를 유도한다.

#### 구현방안
*GNU 보드 게시판을 커스터마이징 해서 개인화 한다.
*퍼블리싱 기능 역시 GNU 보드 게시판을 커스터마이징해서 구현한다.
*타임라인 형태는 전문 디자인 업체에 의뢰하여 UX를 기반으로 직관적 페이지가 될수 있도록 구현한다.