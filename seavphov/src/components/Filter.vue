<template>
  <div>
    <div class="Filter nyvathxx">
      <div class="search-container">
        <div class="search-style"><search-input /></div>
        <div class="wrapper">
          <div id="buttons">
            <!-- Buttons for filtering categories -->
            <button class="button-value" @click="filterBook('all')">All</button>
            <button class="button-value" @click="filterBook('History')">
              History
            </button>
            <button class="button-value" @click="filterBook('Science')">
              Science
            </button>
            <button class="button-value" @click="filterBook('Fantasy')">
              Fantasy
            </button>
            <button class="button-value" @click="filterBook('Text-Book')">
              Text-Book
            </button>
            <button class="button-value" @click="filterBook('Novel')">
              Novel
            </button>
          </div>
        </div>
      </div>
    </div>
    <div id="books">
      <RenderBook :books="filteredBooks" />
    </div>
  </div>
</template>

<script>
import RenderBook from "./RenderBook.vue";
import SearchInput from "./SearchInput.vue";
export default {
  components: { RenderBook, SearchInput },
  data() {
    return {
      selectedCategory: "all",
      books: [
        {
          id: 1,
          title: "Hic ea quo magnam tenetur repellat delectus consequuntur.",
          author: "Kurtis Ebert",
          condition: "Well-worn",
          categories: "History",
          images: "https://m.media-amazon.com/images/I/41DUYpLnKAL.jpg",
          availability: 1,
          descriptions:
            "Temporibus qui facere neque earum enim numquam dolorem voluptas et ad itaque natus necessitatibus nulla illum illum quas rem assumenda explicabo quidem non velit repellendus facilis fuga assumenda rerum ut laboriosam maiores impedit enim pariatur maxime facilis dolor voluptas recusandae maxime aut eaque velit quis error nihil aperiam iusto rerum voluptas dignissimos ducimus id in voluptate autem et id nobis ea et sunt ut itaque tenetur ab quo vero molestiae repellat ipsa ut quo at accusamus libero quia sint est animi doloremque accusantium aut voluptate libero esse eius iste nihil eos perspiciatis omnis est consequatur non deleniti voluptates ut qui numquam laborum nobis aut quidem et necessitatibus sunt voluptatem ullam est repudiandae qui sit excepturi sed velit sunt enim fugiat harum repellendus quo ut iure suscipit occaecati voluptas commodi eum nihil et qui voluptatem veritatis harum laudantium dolorum et quis accusamus eius sunt sed aspernatur ut velit ab nemo animi et velit suscipit reiciendis veritatis rerum nam et eaque fugiat magnam dolorum ea est est excepturi dolore incidunt expedita nesciunt quae rerum doloribus necessitatibus deleniti ex dicta dolor autem beatae sint ipsa et eligendi est voluptates occaecati facere quis et libero sunt qui voluptatem qui et et est accusamus quibusdam at veniam fuga pariatur nostrum ex qui dolorem dolores illum non excepturi dolor enim voluptatem corrupti optio eum rerum tenetur possimus recusandae officiis sint reprehenderit perspiciatis ipsa temporibus est vero consequatur illo qui dicta quia qui consequatur voluptas sit facilis ut similique qui molestiae et et officiis nobis debitis assumenda sapiente eaque ut aut quisquam possimus ut sed cum enim et quaerat sed occaecati molestiae ipsa molestiae illo accusamus et possimus fugiat rerum et sit aut quidem accusamus unde laborum necessitatibus similique ratione corporis atque commodi est est reiciendis magni et hic ut rerum ut eius dolor aperiam molestias delectus deserunt error non eveniet beatae rerum voluptatem placeat assumenda provident repellat voluptatem modi non eaque quidem praesentium ea sit aut quam tempore iusto et quia atque voluptas molestiae non placeat magnam nostrum animi distinctio asperiores in quidem architecto et suscipit quibusdam qui corrupti id sed qui minima repudiandae atque autem molestiae qui soluta repellat vitae neque dolores est.",
          created_at: "2024-04-11T03:48:32.000000Z",
          updated_at: "2024-04-11T03:48:32.000000Z",
          owner_id: 3,
        },
        {
          id: 2,
          title: "Architecto nulla ut veritatis voluptates ut.",
          author: "Janae Metz",
          condition: "Well-worn",
          categories: "Science",
          images:
            "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTRYdW0gjTSHgxQERYPKpMNodyQ5DhaWhQUYg&usqp=CAU",
          availability: 1,
          descriptions:
            "Et repellat magnam non vel eum dicta quis sed in earum corporis sapiente voluptas ad similique maxime iusto voluptatem commodi aperiam deleniti laboriosam dolor ea expedita quo tempore magnam nostrum ea velit illo necessitatibus nisi nam dignissimos vero laborum dolor at fuga temporibus recusandae voluptas aut dicta quia fugit et dolorum aperiam est maiores delectus ab porro perspiciatis odit aut illum sequi vitae asperiores excepturi cum nemo laudantium deleniti quia voluptas laborum sed laborum doloribus voluptas et magni ipsam ducimus at aspernatur in culpa blanditiis hic hic quibusdam exercitationem ipsa quisquam vel itaque eligendi officia culpa pariatur expedita porro libero quidem qui eveniet velit et est omnis quas animi doloremque sed voluptatum nobis quo non fugit ullam nostrum voluptas optio libero deserunt voluptas aut eaque animi officia libero iste qui et reiciendis qui et quisquam et qui et animi tempora dolor ut vero sint beatae sunt voluptate est molestiae eos id vero voluptates hic deserunt qui modi quam sint exercitationem dicta iure occaecati quos dicta reiciendis tempore nihil in maxime ut est quidem minus consectetur tempora consequatur ut sapiente minus officia nostrum sed quidem dolor laborum consequatur ipsam rerum est voluptatum voluptate qui eos ullam omnis natus ea voluptatem architecto laudantium et ut quo quo rerum doloremque quae.",
          created_at: "2024-04-11T03:48:32.000000Z",
          updated_at: "2024-04-11T03:48:32.000000Z",
          owner_id: 1,
        },
        {
          id: 3,
          title: "Et omnis voluptas est laudantium.",
          author: "Amelie Romaguera DDS",
          condition: "Well-worn",
          categories: "Science",
          images:
            "https://m.media-amazon.com/images/I/71nsY8QKNCL._AC_UF894,1000_QL80_.jpg",
          availability: 1,
          descriptions:
            "Reiciendis quia officiis aut dolor magnam unde quia cumque consequatur incidunt autem facere repellat temporibus voluptatem commodi aut architecto mollitia velit nesciunt ea consequuntur similique rerum repellat corrupti nostrum dicta ullam illo culpa rerum ea alias libero et sed quia molestiae quo natus fugit quo ab aperiam maxime odit eum et voluptatem qui soluta voluptatibus dolores explicabo voluptatibus cumque ipsam nihil labore ut accusantium autem occaecati maiores veritatis blanditiis ut qui deleniti quos explicabo quibusdam quam repellat nisi aut inventore labore laboriosam incidunt voluptas enim et labore officia animi veritatis cupiditate aut aspernatur aliquam aperiam exercitationem aut reprehenderit veniam iusto debitis aut animi recusandae sit optio quos ducimus nihil reiciendis molestiae distinctio sint nemo aperiam et quos praesentium reiciendis velit dolor rerum sed libero repellat debitis nobis vitae et distinctio eius cum voluptatem tempora et est reprehenderit veritatis quasi sed quisquam velit animi asperiores enim natus quaerat illo sit deserunt natus ea velit sint non sint quibusdam et laudantium error delectus molestiae accusamus expedita omnis consequuntur nihil dicta deserunt quis expedita dolore qui nulla in inventore necessitatibus incidunt iusto molestiae reprehenderit sint sit corporis quas sit et porro alias incidunt voluptatibus illum aut facilis sint fugit aliquam eius quos tenetur illo temporibus at et quod.",
          created_at: "2024-04-11T03:48:32.000000Z",
          updated_at: "2024-04-11T03:48:32.000000Z",
          owner_id: 4,
        },
        {
          id: 4,
          title:
            "Unde beatae temporibus excepturi quia deserunt consequatur veniam aut.",
          author: "Harmon Ratke MD",
          condition: "As New",
          categories: "Fantasy",
          images:
            "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTRYdW0gjTSHgxQERYPKpMNodyQ5DhaWhQUYg&usqp=CAU",
          availability: 1,
          descriptions:
            "Aut accusantium est rerum nihil cupiditate qui voluptas laudantium consequuntur aut voluptas ex asperiores aut inventore sapiente et tenetur eveniet animi quasi accusamus vel tenetur ipsa possimus eum atque non labore consectetur et voluptatem quia tempore rem esse rerum explicabo sit qui numquam eaque alias aut non aut laborum qui qui omnis officiis sit voluptas aut ut repellendus voluptate itaque voluptatem sit accusamus et aliquid aliquid eius consequuntur adipisci saepe impedit aut sit accusamus corporis voluptatem voluptatem minima occaecati quo nobis quibusdam nostrum et mollitia quo est modi voluptatem aut maiores voluptatem laborum omnis molestias aut repellendus alias vitae molestiae illo in delectus minus possimus ut minus soluta sit sunt voluptas quod occaecati quis eius fuga voluptatibus optio in quo beatae laborum distinctio amet alias sed vero dolorem facilis tenetur dolorem ullam explicabo doloribus animi iusto nulla iusto minima sequi debitis eligendi quaerat ullam atque consequatur et dignissimos quia molestiae et at excepturi ut nostrum molestiae vitae sed quas in voluptatibus maiores qui est laboriosam qui voluptatem quia vel rerum velit velit cum et nemo ipsa dicta ullam et voluptatum corrupti rerum eos neque hic inventore sapiente quae in commodi.",
          created_at: "2024-04-11T03:48:32.000000Z",
          updated_at: "2024-04-11T03:48:32.000000Z",
          owner_id: 5,
        },
        {
          id: 5,
          title: "Ratione magnam recusandae animi dolorem.",
          author: "Gerry Kerluke",
          condition: "As New",
          categories: "Science",
          images:
            "https://m.media-amazon.com/images/I/61HwGVfo+oL._AC_UF1000,1000_QL80_.jpg",
          availability: 1,
          descriptions:
            "Reiciendis dolor amet eaque quaerat rerum blanditiis beatae aut ad ab qui nostrum quo est vero voluptas harum aut magni quas minima perspiciatis aut vel illum fuga eaque explicabo et fugit eveniet et est sed ut sunt odio voluptas veniam est hic sit dignissimos consequatur in earum explicabo qui at quam rem rem delectus beatae repudiandae qui aut ea vitae magnam voluptate corrupti quia error ab vero impedit alias numquam nam aliquid minus ut sit et animi vero est quaerat nisi itaque in in aut ex sequi et necessitatibus ad error voluptatibus ea architecto sed deleniti fugiat quos aliquid voluptas quisquam doloremque eveniet nihil sed suscipit voluptas dolor omnis recusandae blanditiis commodi a sit in eveniet vel sint harum voluptatem fuga occaecati est rem cumque aliquam ab quia est reiciendis ut itaque quibusdam illum omnis assumenda nulla debitis fugit incidunt corporis soluta hic quas officiis nihil sit delectus qui voluptatem facere quia impedit eius porro dolorem voluptatum illum voluptas et aliquam rerum molestiae maiores vel ea doloribus facere aliquid consequatur ut tenetur a reprehenderit ducimus et quaerat et amet qui est eligendi deleniti deleniti quos sit sequi dolore ea provident veritatis aut vel incidunt est facere autem illo sint est mollitia et exercitationem minima et repellat voluptatem corrupti ut quasi et minus tempora omnis eius voluptatem nihil ut placeat quis odit alias qui unde et odio veritatis voluptate amet recusandae tempora sed non qui fugiat quam et atque non ullam nisi earum eius ipsum excepturi molestiae ut voluptatem non rerum rerum ut sequi veritatis dicta ex dolorem corporis omnis aut dolores aspernatur magni cupiditate quod voluptate corporis non ut a fuga libero voluptates est dolorem omnis voluptatem deleniti non rerum rerum aut enim.",
          created_at: "2024-04-11T03:48:32.000000Z",
          updated_at: "2024-04-11T03:48:32.000000Z",
          owner_id: 4,
        },
        {
          id: 6,
          title: "Sit maiores repudiandae culpa cum voluptatibus.",
          author: "Leon Blanda",
          condition: "Good",
          categories: "Fantasy",
          images: "https://m.media-amazon.com/images/I/51c4QW3+HfL.jpg",
          availability: 1,
          descriptions:
            "Reiciendis provident ad est possimus esse quod dignissimos et ut ut ut est quidem odio omnis qui aspernatur sint sunt modi quaerat cumque autem praesentium laudantium dicta quo quam quaerat commodi aliquid eum totam nobis aut animi omnis molestiae qui aut placeat inventore expedita voluptatem illum expedita deserunt veniam expedita velit vero nulla tempore facere illum neque quisquam assumenda libero odit ullam in et quidem optio id pariatur est tenetur porro cupiditate architecto explicabo aut dolorem atque illum optio cupiditate necessitatibus reprehenderit placeat dolor ut quae ipsum recusandae excepturi impedit ea minima sit et consequuntur ut doloribus praesentium quasi maxime optio voluptatum nesciunt est qui dolor omnis ut sit ex cupiditate sequi illo pariatur quos similique possimus tempore rerum quod temporibus quia ab qui in rem quasi voluptatem reiciendis sit recusandae non beatae et inventore ipsam saepe ut impedit maiores voluptatem voluptatibus hic eligendi placeat quia dolores adipisci voluptate deleniti vel voluptatum debitis quo accusamus in quo sint aut et culpa inventore ipsam corporis consectetur ut dolor et in ea et sint blanditiis eligendi reprehenderit sint sit vel sit pariatur rerum autem voluptates explicabo totam architecto expedita.",
          created_at: "2024-04-11T03:48:32.000000Z",
          updated_at: "2024-04-11T03:48:32.000000Z",
          owner_id: 4,
        },
        {
          id: 7,
          title: "Modi dolor inventore ullam est et omnis adipisci.",
          author: "Ms. Meagan Mohr",
          condition: "As New",
          categories: "Text-Book",
          images: "https://m.media-amazon.com/images/I/41DUYpLnKAL.jpg",
          availability: 1,
          descriptions:
            "Quos fuga ut ipsum incidunt error quia odio qui quasi aliquam eius excepturi eius assumenda consequatur mollitia tenetur soluta aut ipsam rem delectus hic non ad labore accusamus omnis dolorem accusamus culpa minima cupiditate qui quisquam voluptas non aut hic quas magni modi quibusdam sed accusamus dignissimos et enim voluptatibus tenetur suscipit eos quas illum voluptas et aut ullam quia suscipit tempora id at omnis eos distinctio illum saepe facere velit sunt ut nisi voluptatum deleniti amet distinctio consequuntur molestias blanditiis consequatur nulla et aut qui autem perferendis et voluptatem quibusdam voluptas sunt eaque dolorem sed tempora nesciunt nihil eaque aut quam quo nisi et qui in hic perspiciatis assumenda quibusdam possimus neque dignissimos at corporis magni saepe vel accusamus officiis error natus autem est totam consectetur praesentium vel temporibus ut aut nam ipsam est est facere expedita velit earum non expedita architecto sit neque provident alias animi asperiores accusantium asperiores id ducimus dolor sit aut dolorem consequatur voluptas maiores ea expedita et id iure soluta totam quibusdam ut doloribus saepe accusantium enim ut pariatur porro iure cum hic harum id et mollitia quo veritatis perferendis ea eius reiciendis et nesciunt officia ad est voluptatem maiores aliquam hic id esse vero rerum rerum autem et in in sed rerum ut dolore velit cumque qui velit iure maxime occaecati voluptatem quam qui nihil exercitationem error ut rerum porro inventore quae sapiente architecto incidunt a quas non error nulla eum et amet sint rem consectetur quos iure quae aut veritatis numquam iure fugit corporis accusamus fugiat exercitationem dolorum illum voluptate quia debitis nemo est dolores et suscipit.",
          created_at: "2024-04-11T03:48:32.000000Z",
          updated_at: "2024-04-11T03:48:32.000000Z",
          owner_id: 2,
        },
        {
          id: 8,
          title: "Aperiam quibusdam perferendis ut modi commodi.",
          author: "Leone Cormier",
          condition: "As New",
          categories: "Science",
          images:
            "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTRYdW0gjTSHgxQERYPKpMNodyQ5DhaWhQUYg&usqp=CAU",
          availability: 1,
          descriptions:
            "Beatae quasi sint ut autem quae eos inventore atque id odio esse beatae perferendis eum ipsa nam dolores distinctio tenetur commodi quibusdam aperiam ut animi quam distinctio aliquid qui harum et quisquam ipsum optio et voluptas consequuntur magnam corrupti quidem in voluptatem ea alias aperiam sed quisquam eius maxime inventore similique pariatur consequatur doloribus corporis corporis error qui molestias et occaecati consequatur commodi est magni laboriosam reprehenderit rerum quidem ut ea enim illum veritatis sapiente facere voluptas rerum et quod dolore dolorem architecto mollitia earum aliquam nisi et et quasi aperiam omnis laborum neque excepturi quos nihil id animi laborum error et eligendi corrupti rerum dicta nostrum et voluptas occaecati qui eaque consequatur nihil corporis id illum rerum quia neque maiores molestiae et in maxime facilis temporibus nisi dolor eum nam eum nihil omnis explicabo ut ut error et tempora laboriosam tempore cumque pariatur non blanditiis nemo nihil officia ut sunt sed iste neque perferendis et est alias dicta ut omnis voluptas voluptatem rerum perferendis voluptas est commodi repellendus quidem quo minus ipsam minima eveniet aperiam ipsa officia et vero asperiores eos voluptas et ratione facilis possimus et consequuntur ut consequatur quia in impedit eum vitae aperiam recusandae perspiciatis est ullam ab iusto quaerat a tempora inventore vitae voluptatibus nostrum quae sit quisquam nulla aut aliquam distinctio qui odio debitis maiores vitae quia ut assumenda aliquam placeat et unde natus occaecati est reiciendis est enim possimus repellat minima aut possimus et minus exercitationem deleniti officiis et aut quidem aliquid quisquam enim repellendus odio quam id debitis eum repellendus qui illo maiores numquam velit nulla et dignissimos et magni modi aperiam deserunt dolor quis eligendi minus tempore aut commodi vero vero voluptatem nihil in dolores quibusdam enim quidem sint reprehenderit officia minus sunt maxime dolorem omnis est voluptas beatae asperiores harum quo est quod enim sit perspiciatis blanditiis praesentium praesentium enim qui veritatis aut modi possimus quod a atque saepe et nobis recusandae recusandae aliquid in eum rerum reiciendis in nesciunt doloribus fuga quia qui alias sint accusamus ad aperiam dicta aperiam ex est hic id quia ab consequatur sapiente id sunt id doloremque eos est officiis sed qui qui unde provident quis nostrum accusantium fugit qui commodi tenetur tempore est sed quo est quae enim dicta.",
          created_at: "2024-04-11T03:48:32.000000Z",
          updated_at: "2024-04-11T03:48:32.000000Z",
          owner_id: 1,
        },
        {
          id: 9,
          title: "Possimus vitae velit dignissimos dolores voluptates.",
          author: "Prof. Baylee Harris PhD",
          condition: "Good",
          categories: "Novel",
          images: "https://m.media-amazon.com/images/I/51uqS5M6KtL.jpg",
          availability: 1,
          descriptions:
            "Fugiat aspernatur et natus labore dignissimos facilis voluptatem maxime sunt quasi consequatur beatae ut voluptas saepe qui et odit ea fugiat illum quis et minus reiciendis consectetur voluptatem in fugiat assumenda velit minus nihil praesentium sint illum quis vel eveniet nemo id molestias similique dolorum a quidem rerum qui adipisci est adipisci voluptas numquam inventore ut est tempore nam temporibus at in autem aperiam neque aut ut cum et iure repudiandae sint sit sapiente eligendi rerum doloremque sint deserunt natus quaerat libero quo in et dignissimos et non est iusto odio autem libero hic voluptatum ipsam inventore quam beatae voluptate eaque ut et molestiae a sit eveniet molestiae dolorum unde porro cumque nemo veritatis sed sapiente ut id voluptates est autem ut ad voluptatem perspiciatis incidunt laborum similique rerum quo esse dignissimos laboriosam culpa minima non ipsum amet vel dolor voluptatem qui officia repellat animi aut laudantium qui aut nemo est dolores voluptatem neque deleniti corrupti officia doloremque perspiciatis aut ut mollitia impedit fuga molestias voluptates et voluptatum et quo non harum sed et laboriosam iusto in consectetur soluta quia architecto voluptas id quas quis ut doloremque eveniet optio alias atque velit laboriosam labore exercitationem et rerum pariatur repudiandae velit beatae eligendi esse et voluptatem harum illum nihil aperiam ut pariatur ut sed hic qui voluptas cupiditate aut consectetur minima corrupti nam et ut aut dicta vel dolores nemo excepturi alias ea magni quasi officiis qui placeat blanditiis eveniet est harum provident voluptates facilis magni sunt omnis doloribus odit labore natus quia atque quas et veniam nulla rerum voluptate autem qui consectetur deserunt quis magni aperiam molestiae voluptatem quas voluptates consectetur ut excepturi facilis.",
          created_at: "2024-04-11T03:48:33.000000Z",
          updated_at: "2024-04-11T03:48:33.000000Z",
          owner_id: 1,
        },
        {
          id: 10,
          title: "Quod in quia quia saepe sunt cupiditate.",
          author: "Wade Gleason",
          condition: "As New",
          categories: "History",
          images: "https://m.media-amazon.com/images/I/51uqS5M6KtL.jpg",
          availability: 1,
          descriptions:
            "Qui sint optio voluptatem placeat voluptatibus natus qui porro ex qui praesentium modi perferendis doloribus voluptate eos voluptates sint architecto ullam autem labore repellendus nihil labore eos sint vel temporibus in consectetur voluptate omnis ut eius iste adipisci omnis consequatur voluptatibus corrupti esse autem neque quam voluptas vel aliquam illo eaque alias neque autem beatae sed et et sit quia consequatur hic est rerum inventore omnis exercitationem velit quas ratione earum id enim a cupiditate optio aut omnis provident est molestiae aut et error eaque numquam omnis quasi et et laboriosam quia aliquam velit enim adipisci quod rerum sed minus at quaerat nihil sapiente sit voluptas quasi sint dolorum ducimus occaecati molestias voluptatem nobis ea voluptas mollitia suscipit placeat iure ut impedit est cum quia nisi et sed asperiores aut fugit dolorem rerum officia officiis eum incidunt ut et sit itaque ut quia ex recusandae fugit et sed corporis cum voluptas enim unde et vel eos error reiciendis veniam et voluptatem et ratione porro eius qui eum natus sit dolores et omnis explicabo doloribus aut soluta aut aliquam officiis sit in qui illum et aut a cupiditate quae omnis dolor doloribus dolore praesentium magnam et provident ex voluptates ipsa.",
          created_at: "2024-04-11T03:48:33.000000Z",
          updated_at: "2024-04-11T03:48:33.000000Z",
          owner_id: 3,
        },
      ],
    };
  },
  computed: {
    filteredBooks() {
      if (this.selectedCategory === "all") {
        return this.books;
      } else {
        return this.books.filter(
          (book) => book["categories"] == this.selectedCategory
        );
      }
    },
  },
  methods: {
    filterBook(category) {
      this.selectedCategory = category;
    },
  },
};
</script>

<style>
/* Your CSS styles */
/* Your CSS styles */

.search-style {
  padding: 20px;
}
* {
  padding: 0;
  margin: 0;
  box-sizing: border-box;
  border: none;
  outline: none;
  font-family: "Poppins", sans-serif;
}

body {
  background-color: #f5f8ff;
}

.wrapper {
  width: 95%;
  /* margin: 0 auto; */
  margin-bottom: 10px;
  justify-content: center;
}

.nyvathxx {
  background: #37aba3;
  opacity: 1;
  border-radius: 3%;
}

#buttons {
  display: flex;
  /* margin-top: 1em; */
  /* margin: 0px; */
  /* gap: 10px; */
  justify-content: center;
}

.button-value {
  border: 2px solid #37aba3;
  padding: 0.5em 2em;
  border-radius: 3em;
  background-color: #dddddd;
  color: #37aba3;
  cursor: pointer;
  transition: background-color 0.3s, color 0.3s;
}
.button-value:hover {
  background-color: #37aba3;
  color: #ffffff;
}
.button-value.active {
  background-color: #37aba3;
  color: #ffffff;
}

#books {
  padding: 2em 0;
}

#books .card {
  background-color: #ffffff;
  max-width: 18em;
  margin-top: 1em;
  padding: 1em;
  border-radius: 5px;
  box-shadow: 1em 2em 2.5em rgba(1, 2, 68, 0.08);
}

#books .image-container {
  text-align: center;
}

#books img {
  max-width: 100%;
  object-fit: contain;
  height: 15em;
}

#books .container {
  padding-top: 1em;
  color: #110f29;
}

#books .container h5 {
  font-weight: 500;
}

.hide {
  display: none;
}

@media screen and (max-width: 720px) {
  #books img {
    max-width: 100%;
    object-fit: contain;
    height: 10em;
  }

  #books .card {
    max-width: 10em;
    margin-top: 1em;
  }
}
</style>
