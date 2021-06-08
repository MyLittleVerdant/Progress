using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;
using System.Runtime.InteropServices;

namespace _11
{
    public partial class Form1 : Form
    {
        public Form1()
        {
            InitializeComponent();
        }
        
        public const int TVIF_STATE = 0x8;
        public const int TVIS_STATEIMAGEMASK = 0xF000;
        public const int TV_FIRST = 0x1100;
        public const int TVM_SETITEM = TV_FIRST + 63;


        [DllImport("user32.dll")]
        static extern IntPtr SendMessage(IntPtr hWnd, uint Msg, IntPtr wParam, IntPtr lParam);
        public struct TVITEM
        {
            public int mask;
            public IntPtr hItem;
            public int state;
            public int stateMask;
            [MarshalAs(UnmanagedType.LPTStr)]
            public String lpszText;
            public int cchTextMax;
            public int iImage;
            public int iSelectedImage;
            public int cChildren;
            public IntPtr lParam;
        }

        private void treeView_DrawNode(object sender, DrawTreeNodeEventArgs e)
        {
            //-- Если это нужный узел, то не рисуем checkbox
            if (e.Node.Text.Equals("Страна") || e.Node.Text.Equals("Дата выхода") || e.Node.Text.Equals("Жанр"))
            {
                // скрываем CheckBox вызовом функции
                HideCheckBox(e.Node);
            }
            e.DrawDefault = true;

        }
        private void HideCheckBox(TreeNode node)
        {
            TVITEM tvi = new TVITEM();
            tvi.hItem = node.Handle;
            tvi.mask = TVIF_STATE;
            tvi.stateMask = TVIS_STATEIMAGEMASK;
            tvi.state = 0;
            IntPtr lparam = Marshal.AllocHGlobal(Marshal.SizeOf(tvi));
            Marshal.StructureToPtr(tvi, lparam, false);
            SendMessage(this.treeView1.Handle, TVM_SETITEM, IntPtr.Zero, lparam);
        }

        private void listView1_SelectedIndexChanged(object sender, EventArgs e)
        {
            if (listView1.Items[0].Selected==true)
            {
                label1.Text = "«Тетрадь Смерти» обрела невероятную популярность в начале века онлайн, сделав историю противостояния Киры и гениального детектива L классикой детективного жанра и просто культовым аниме";
            }
            if (listView1.Items[1].Selected == true)
            {
                label1.Text = "«Гуррен-Лаганн» или Tengen Toppa Gurren Lagann — аниме-сериал режиссёра Хироюки Имаиси, выпускавшийся студией Gainax с 1 апреля по 30 сентября 2007 года";
            }
            if (listView1.Items[2].Selected == true)
            {
                label1.Text = " Главный герой — Тоа Токути — талантливый питчер, попадающий в профессиональную бейсбольную команду Ликаонс.";
            }
            if (listView1.Items[3].Selected == true)
            {
                label1.Text = "Нарушив главный запрет Алхимии и попытавшись воскресить маму, талантливые братья Элрики заплатили высокую цену: младший, Альфонс, потерял тело, и теперь его душа прикреплена к стальным доспехам, а старший, Эдвард, лишился руки и ноги, поэтому ему приходится пользоваться протезами — автобронёй.";
            }
            if (listView1.Items[4].Selected == true)
            {
                label1.Text = "Художественный фильм о покойном Иене (Яне) Кертисе, загадочном ведущем певце культовой английской пост-панковской группы Joy Division, рассказывает о нескольких последних годах его жизни, завершившихся трагическим самоубийством в 1980 году.";
            }
            if (listView1.Items[5].Selected == true)
            {
                label1.Text = "Фильм «Подстрочник» — киномонолог Лилианны Лунгиной о жизни души и мира вокруг. С беспощадной зоркостью рассматривая собственное развитие с малых лет до последних дней, она делает внутренние события не менее увлекательными, чем внешние.";
            }
            if (listView1.Items[6].Selected == true)
            {
                label1.Text = "«Ма́ска Зо́рро» — фильм-вестерн 1998 года режиссёра Мартина Кэмпбелла с Антонио Бандерасом, Энтони Хопкинсом и Кэтрин Зетой-Джонс в главных ролях.";
            }
        }

        private void treeView1_AfterCheck(object sender, TreeViewEventArgs e)
        {
            


        }

        private void treeView1_AfterSelect(object sender, TreeViewEventArgs e)
        {

        }

        private void treeView1_NodeMouseClick(object sender, TreeNodeMouseClickEventArgs e)
        {
           
        }

        private void treeView1_Click(object sender, EventArgs e)
        {
            if (treeView1.Nodes[0].Nodes[0].Checked == false && treeView1.Nodes[0].Nodes[1].Checked == false && treeView1.Nodes[0].Nodes[2].Checked == false && treeView1.Nodes[1].Nodes[0].Checked == false && treeView1.Nodes[1].Nodes[1].Checked == false && treeView1.Nodes[1].Nodes[2].Checked == false && treeView1.Nodes[2].Nodes[0].Checked == false && treeView1.Nodes[2].Nodes[1].Checked == false && treeView1.Nodes[2].Nodes[2].Checked == false)
            {
                listView1.Items.Clear();
                ListViewItem item1 = new ListViewItem("Тетрадь смерти", 0);
                item1.SubItems.Add("Аниме");
                item1.SubItems.Add("2007");
                item1.SubItems.Add("Япония");
                listView1.Items.Add(item1);
                ListViewItem item2 = new ListViewItem("Гуррен-Лаганн", 0);
                item2.SubItems.Add("Аниме");
                item2.SubItems.Add("2007");
                item2.SubItems.Add("Япония");
                listView1.Items.Add(item2);
                ListViewItem item3 = new ListViewItem("Один на вылет", 0);
                item3.SubItems.Add("Аниме");
                item3.SubItems.Add("2008");
                item3.SubItems.Add("Япония");
                listView1.Items.Add(item3);
                ListViewItem item4 = new ListViewItem("Стальной алхимик", 0);
                item4.SubItems.Add("Аниме");
                item4.SubItems.Add("2009");
                item4.SubItems.Add("Япония");
                listView1.Items.Add(item4);
                ListViewItem item5 = new ListViewItem("Контроль", 0);
                item5.SubItems.Add("Боевик");
                item5.SubItems.Add("2007");
                item5.SubItems.Add("Россия");
                listView1.Items.Add(item5);
                ListViewItem item6 = new ListViewItem("Подстрочник", 0);
                item6.SubItems.Add("Боевик");
                item6.SubItems.Add("2008");
                item6.SubItems.Add("Россия");
                listView1.Items.Add(item6);
                ListViewItem item7 = new ListViewItem("Зорро", 0);
                item7.SubItems.Add("Боевик");
                item7.SubItems.Add("2009");
                item7.SubItems.Add("США");
                listView1.Items.Add(item7);
                ListViewItem item8 = new ListViewItem("Поезд на Юму", 0);
                item8.SubItems.Add("Вестерн");
                item8.SubItems.Add("2007");
                item8.SubItems.Add("США");
                listView1.Items.Add(item8);
                ListViewItem item9 = new ListViewItem("Железная хватка", 0);
                item9.SubItems.Add("Вестерн");
                item9.SubItems.Add("2008");
                item9.SubItems.Add("США");
                listView1.Items.Add(item9);
                ListViewItem item10 = new ListViewItem("Австралия", 0);
                item10.SubItems.Add("Вестерн");
                item10.SubItems.Add("2009");
                item10.SubItems.Add("США");
                listView1.Items.Add(item10);
                ListViewItem item11 = new ListViewItem("Сэм - электрический скат", 0);
                item11.SubItems.Add("Вестерн");
                item11.SubItems.Add("2009");
                item11.SubItems.Add("США");
                listView1.Items.Add(item11);
                treeView1.Nodes[0].Nodes[0].Checked = false;
                treeView1.Nodes[0].Nodes[1].Checked = false;
                treeView1.Nodes[0].Nodes[2].Checked = false;
                treeView1.Nodes[1].Nodes[0].Checked = false;
                treeView1.Nodes[1].Nodes[1].Checked = false;
                treeView1.Nodes[1].Nodes[2].Checked = false;
                treeView1.Nodes[2].Nodes[0].Checked = false;
                treeView1.Nodes[2].Nodes[1].Checked = false;
                treeView1.Nodes[2].Nodes[2].Checked = false;
            }
            if (treeView1.Nodes[0].Nodes[0].Checked == true && treeView1.Nodes[0].Nodes[1].Checked==false && treeView1.Nodes[0].Nodes[2].Checked == false)
            {
                listView1.Items.Clear();
                ListViewItem item1 = new ListViewItem("Тетрадь смерти", 0);
                item1.SubItems.Add("Аниме");
                item1.SubItems.Add("2007");
                item1.SubItems.Add("Япония");
                listView1.Items.Add(item1);
                ListViewItem item2 = new ListViewItem("Гуррен-Лаганн", 0);
                item2.SubItems.Add("Аниме");
                item2.SubItems.Add("2007");
                item2.SubItems.Add("Япония");
                listView1.Items.Add(item2);
                ListViewItem item3 = new ListViewItem("Один на вылет", 0);
                item3.SubItems.Add("Аниме");
                item3.SubItems.Add("2008");
                item3.SubItems.Add("Япония");
                listView1.Items.Add(item3);
                ListViewItem item4 = new ListViewItem("Стальной алхимик", 0);
                item4.SubItems.Add("Аниме");
                item4.SubItems.Add("2009");
                item4.SubItems.Add("Япония");
                listView1.Items.Add(item4);


                HideCheckBox(treeView1.Nodes[0].Nodes[1]);
                HideCheckBox(treeView1.Nodes[0].Nodes[2]);
            }
            if (treeView1.Nodes[0].Nodes[1].Checked == true && treeView1.Nodes[0].Nodes[0].Checked == false && treeView1.Nodes[0].Nodes[2].Checked == false)
            {
                listView1.Items.Clear();
                ListViewItem item5 = new ListViewItem("Контроль", 0);
                item5.SubItems.Add("Боевик");
                item5.SubItems.Add("2007");
                item5.SubItems.Add("Россия");
                listView1.Items.Add(item5);
                ListViewItem item6 = new ListViewItem("Подстрочник", 0);
                item6.SubItems.Add("Боевик");
                item6.SubItems.Add("2008");
                item6.SubItems.Add("Россия");
                listView1.Items.Add(item6);
                ListViewItem item7 = new ListViewItem("Зоро", 0);
                item7.SubItems.Add("Боевик");
                item7.SubItems.Add("2009");
                item7.SubItems.Add("США");
                listView1.Items.Add(item7);
                HideCheckBox(treeView1.Nodes[0].Nodes[0]);
                HideCheckBox(treeView1.Nodes[0].Nodes[2]);
            }
            if (treeView1.Nodes[0].Nodes[2].Checked == true && treeView1.Nodes[0].Nodes[0].Checked == false && treeView1.Nodes[0].Nodes[1].Checked == false)
            {
                listView1.Items.Clear();
                ListViewItem item8 = new ListViewItem("Поезд на Юму", 0);
                item8.SubItems.Add("Вестерн");
                item8.SubItems.Add("2007");
                item8.SubItems.Add("США");
                listView1.Items.Add(item8);
                ListViewItem item9 = new ListViewItem("Железная хватка", 0);
                item9.SubItems.Add("Вестерн");
                item9.SubItems.Add("2008");
                item9.SubItems.Add("США");
                listView1.Items.Add(item9);
                ListViewItem item10 = new ListViewItem("Австралия", 0);
                item10.SubItems.Add("Вестерн");
                item10.SubItems.Add("2009");
                item10.SubItems.Add("США");
                listView1.Items.Add(item10);
                ListViewItem item11 = new ListViewItem("Сэм - электрический скат", 0);
                item11.SubItems.Add("Вестерн");
                item11.SubItems.Add("2009");
                item11.SubItems.Add("США");
                listView1.Items.Add(item11);
                HideCheckBox(treeView1.Nodes[0].Nodes[0]);
                HideCheckBox(treeView1.Nodes[0].Nodes[1]);
            }
            if (treeView1.Nodes[1].Nodes[0].Checked == true && treeView1.Nodes[1].Nodes[1].Checked == false && treeView1.Nodes[1].Nodes[2].Checked == false)
            {
                listView1.Items.Clear();
                listView1.Items.Clear();
                ListViewItem item1 = new ListViewItem("Тетрадь смерти", 0);
                item1.SubItems.Add("Аниме");
                item1.SubItems.Add("2007");
                item1.SubItems.Add("Япония");
                listView1.Items.Add(item1);
                ListViewItem item2 = new ListViewItem("Гуррен-Лаганн", 0);
                item2.SubItems.Add("Аниме");
                item2.SubItems.Add("2007");
                item2.SubItems.Add("Япония");
                listView1.Items.Add(item2);
                ListViewItem item5 = new ListViewItem("Контроль", 0);
                item5.SubItems.Add("Боевик");
                item5.SubItems.Add("2007");
                item5.SubItems.Add("Россия");
                listView1.Items.Add(item5);
                ListViewItem item8 = new ListViewItem("Поезд на Юму", 0);
                item8.SubItems.Add("Вестерн");
                item8.SubItems.Add("2007");
                item8.SubItems.Add("США");
                listView1.Items.Add(item8);

                HideCheckBox(treeView1.Nodes[1].Nodes[1]);
                HideCheckBox(treeView1.Nodes[1].Nodes[2]);
            }
            if (treeView1.Nodes[1].Nodes[1].Checked == true && treeView1.Nodes[1].Nodes[0].Checked == false && treeView1.Nodes[1].Nodes[2].Checked == false)
            {
                listView1.Items.Clear();
                ListViewItem item3 = new ListViewItem("Один на вылет", 0);
                item3.SubItems.Add("Аниме");
                item3.SubItems.Add("2008");
                item3.SubItems.Add("Япония");
                listView1.Items.Add(item3);
                ListViewItem item6 = new ListViewItem("Подстрочник", 0);
                item6.SubItems.Add("Боевик");
                item6.SubItems.Add("2008");
                item6.SubItems.Add("Россия");
                listView1.Items.Add(item6);
                ListViewItem item9 = new ListViewItem("Железная хватка", 0);
                item9.SubItems.Add("Вестерн");
                item9.SubItems.Add("2008");
                item9.SubItems.Add("США");
                listView1.Items.Add(item9);

                HideCheckBox(treeView1.Nodes[1].Nodes[0]);
                HideCheckBox(treeView1.Nodes[1].Nodes[2]);
            }
            if (treeView1.Nodes[1].Nodes[2].Checked == true && treeView1.Nodes[1].Nodes[0].Checked == false && treeView1.Nodes[1].Nodes[1].Checked == false)
            {
                listView1.Items.Clear();
                ListViewItem item4 = new ListViewItem("Стальной алхимик", 0);
                item4.SubItems.Add("Аниме");
                item4.SubItems.Add("2009");
                item4.SubItems.Add("Япония");
                listView1.Items.Add(item4);
                ListViewItem item7 = new ListViewItem("Зоро", 0);
                item7.SubItems.Add("Боевик");
                item7.SubItems.Add("2009");
                item7.SubItems.Add("США");
                listView1.Items.Add(item7);
                ListViewItem item10 = new ListViewItem("Австралия", 0);
                item10.SubItems.Add("Вестерн");
                item10.SubItems.Add("2009");
                item10.SubItems.Add("США");
                listView1.Items.Add(item10);
                ListViewItem item11 = new ListViewItem("Сэм - электрический скат", 0);
                item11.SubItems.Add("Вестерн");
                item11.SubItems.Add("2009");
                item11.SubItems.Add("США");
                listView1.Items.Add(item11);


                HideCheckBox(treeView1.Nodes[1].Nodes[0]);
                HideCheckBox(treeView1.Nodes[1].Nodes[1]);
            }
            if (treeView1.Nodes[2].Nodes[0].Checked == true && treeView1.Nodes[2].Nodes[1].Checked == false && treeView1.Nodes[2].Nodes[2].Checked == false)
            {
                listView1.Items.Clear();
                ListViewItem item5 = new ListViewItem("Контроль", 0);
                item5.SubItems.Add("Боевик");
                item5.SubItems.Add("2007");
                item5.SubItems.Add("Россия");
                listView1.Items.Add(item5);
                ListViewItem item6 = new ListViewItem("Подстрочник", 0);
                item6.SubItems.Add("Боевик");
                item6.SubItems.Add("2008");
                item6.SubItems.Add("Россия");
                listView1.Items.Add(item6);


                HideCheckBox(treeView1.Nodes[2].Nodes[1]);
                HideCheckBox(treeView1.Nodes[2].Nodes[2]);
            }
            if (treeView1.Nodes[2].Nodes[1].Checked == true && treeView1.Nodes[2].Nodes[0].Checked == false && treeView1.Nodes[2].Nodes[2].Checked == false)
            {
                listView1.Items.Clear();
                ListViewItem item7 = new ListViewItem("Зоро", 0);
                item7.SubItems.Add("Боевик");
                item7.SubItems.Add("2009");
                item7.SubItems.Add("США");
                listView1.Items.Add(item7);
                ListViewItem item8 = new ListViewItem("Поезд на Юму", 0);
                item8.SubItems.Add("Вестерн");
                item8.SubItems.Add("2007");
                item8.SubItems.Add("США");
                listView1.Items.Add(item8);
                ListViewItem item9 = new ListViewItem("Железная хватка", 0);
                item9.SubItems.Add("Вестерн");
                item9.SubItems.Add("2008");
                item9.SubItems.Add("США");
                listView1.Items.Add(item9);
                ListViewItem item10 = new ListViewItem("Австралия", 0);
                item10.SubItems.Add("Вестерн");
                item10.SubItems.Add("2009");
                item10.SubItems.Add("США");
                listView1.Items.Add(item10);
                ListViewItem item11 = new ListViewItem("Сэм - электрический скат", 0);
                item11.SubItems.Add("Вестерн");
                item11.SubItems.Add("2009");
                item11.SubItems.Add("США");
                listView1.Items.Add(item11);


                HideCheckBox(treeView1.Nodes[2].Nodes[0]);
                HideCheckBox(treeView1.Nodes[2].Nodes[2]);
            }
            if (treeView1.Nodes[2].Nodes[2].Checked == true && treeView1.Nodes[2].Nodes[0].Checked == false && treeView1.Nodes[2].Nodes[1].Checked == false)
            {
                listView1.Items.Clear();
                ListViewItem item1 = new ListViewItem("Тетрадь смерти", 0);
                item1.SubItems.Add("Аниме");
                item1.SubItems.Add("2007");
                item1.SubItems.Add("Япония");
                listView1.Items.Add(item1);
                ListViewItem item2 = new ListViewItem("Гуррен-Лаганн", 0);
                item2.SubItems.Add("Аниме");
                item2.SubItems.Add("2007");
                item2.SubItems.Add("Япония");
                listView1.Items.Add(item2);
                ListViewItem item3 = new ListViewItem("Один на вылет", 0);
                item3.SubItems.Add("Аниме");
                item3.SubItems.Add("2008");
                item3.SubItems.Add("Япония");
                listView1.Items.Add(item3);
                ListViewItem item4 = new ListViewItem("Стальной алхимик", 0);
                item4.SubItems.Add("Аниме");
                item4.SubItems.Add("2009");
                item4.SubItems.Add("Япония");
                listView1.Items.Add(item4);


                HideCheckBox(treeView1.Nodes[2].Nodes[0]);
                HideCheckBox(treeView1.Nodes[2].Nodes[2]);
            }

        }
    }
    }
