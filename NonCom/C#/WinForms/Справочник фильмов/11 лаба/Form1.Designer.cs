namespace _11
{
    partial class Form1
    {
        /// <summary>
        /// Обязательная переменная конструктора.
        /// </summary>
        private System.ComponentModel.IContainer components = null;

        /// <summary>
        /// Освободить все используемые ресурсы.
        /// </summary>
        /// <param name="disposing">истинно, если управляемый ресурс должен быть удален; иначе ложно.</param>
        protected override void Dispose(bool disposing)
        {
            if (disposing && (components != null))
            {
                components.Dispose();
            }
            base.Dispose(disposing);
        }

        #region Код, автоматически созданный конструктором форм Windows

        /// <summary>
        /// Требуемый метод для поддержки конструктора — не изменяйте 
        /// содержимое этого метода с помощью редактора кода.
        /// </summary>
        private void InitializeComponent()
        {
            System.Windows.Forms.TreeNode treeNode1 = new System.Windows.Forms.TreeNode("Аниме");
            System.Windows.Forms.TreeNode treeNode2 = new System.Windows.Forms.TreeNode("Боевик");
            System.Windows.Forms.TreeNode treeNode3 = new System.Windows.Forms.TreeNode("Вестерн");
            System.Windows.Forms.TreeNode treeNode4 = new System.Windows.Forms.TreeNode("Жанр", new System.Windows.Forms.TreeNode[] {
            treeNode1,
            treeNode2,
            treeNode3});
            System.Windows.Forms.TreeNode treeNode5 = new System.Windows.Forms.TreeNode("2007");
            System.Windows.Forms.TreeNode treeNode6 = new System.Windows.Forms.TreeNode("2008");
            System.Windows.Forms.TreeNode treeNode7 = new System.Windows.Forms.TreeNode("2009");
            System.Windows.Forms.TreeNode treeNode8 = new System.Windows.Forms.TreeNode("Дата выхода", new System.Windows.Forms.TreeNode[] {
            treeNode5,
            treeNode6,
            treeNode7});
            System.Windows.Forms.TreeNode treeNode9 = new System.Windows.Forms.TreeNode("Россия");
            System.Windows.Forms.TreeNode treeNode10 = new System.Windows.Forms.TreeNode("США");
            System.Windows.Forms.TreeNode treeNode11 = new System.Windows.Forms.TreeNode("Япония");
            System.Windows.Forms.TreeNode treeNode12 = new System.Windows.Forms.TreeNode("Страна", new System.Windows.Forms.TreeNode[] {
            treeNode9,
            treeNode10,
            treeNode11});
            this.treeView1 = new System.Windows.Forms.TreeView();
            this.label1 = new System.Windows.Forms.Label();
            this.listView1 = new System.Windows.Forms.ListView();
            this.columnHeader1 = ((System.Windows.Forms.ColumnHeader)(new System.Windows.Forms.ColumnHeader()));
            this.columnHeader2 = ((System.Windows.Forms.ColumnHeader)(new System.Windows.Forms.ColumnHeader()));
            this.columnHeader3 = ((System.Windows.Forms.ColumnHeader)(new System.Windows.Forms.ColumnHeader()));
            this.columnHeader4 = ((System.Windows.Forms.ColumnHeader)(new System.Windows.Forms.ColumnHeader()));
            this.SuspendLayout();
            // 
            // treeView1
            // 
            this.treeView1.CheckBoxes = true;
            this.treeView1.DrawMode = System.Windows.Forms.TreeViewDrawMode.OwnerDrawAll;
            this.treeView1.Location = new System.Drawing.Point(3, 12);
            this.treeView1.Name = "treeView1";
            treeNode1.Name = "Узел5";
            treeNode1.Text = "Аниме";
            treeNode2.Name = "Узел7";
            treeNode2.Text = "Боевик";
            treeNode3.Name = "Узел8";
            treeNode3.Text = "Вестерн";
            treeNode4.Name = "Узел0";
            treeNode4.Text = "Жанр";
            treeNode5.Name = "Узел24";
            treeNode5.Text = "2007";
            treeNode6.Name = "Узел25";
            treeNode6.Text = "2008";
            treeNode7.Name = "Узел26";
            treeNode7.Text = "2009";
            treeNode8.Name = "Узел1";
            treeNode8.Text = "Дата выхода";
            treeNode9.Name = "Узел16";
            treeNode9.Text = "Россия";
            treeNode10.Name = "Узел18";
            treeNode10.Text = "США";
            treeNode11.Name = "Узел19";
            treeNode11.Text = "Япония";
            treeNode12.Name = "Узел3";
            treeNode12.Text = "Страна";
            this.treeView1.Nodes.AddRange(new System.Windows.Forms.TreeNode[] {
            treeNode4,
            treeNode8,
            treeNode12});
            this.treeView1.Size = new System.Drawing.Size(363, 197);
            this.treeView1.TabIndex = 0;
            this.treeView1.AfterCheck += new System.Windows.Forms.TreeViewEventHandler(this.treeView1_AfterCheck);
            this.treeView1.DrawNode += new System.Windows.Forms.DrawTreeNodeEventHandler(this.treeView_DrawNode);
            this.treeView1.NodeMouseClick += new System.Windows.Forms.TreeNodeMouseClickEventHandler(this.treeView1_NodeMouseClick);
            this.treeView1.Click += new System.EventHandler(this.treeView1_Click);
            // 
            // label1
            // 
            this.label1.Location = new System.Drawing.Point(0, 212);
            this.label1.Name = "label1";
            this.label1.Size = new System.Drawing.Size(366, 100);
            this.label1.TabIndex = 1;
            // 
            // listView1
            // 
            this.listView1.Columns.AddRange(new System.Windows.Forms.ColumnHeader[] {
            this.columnHeader1,
            this.columnHeader2,
            this.columnHeader3,
            this.columnHeader4});
            this.listView1.FullRowSelect = true;
            this.listView1.GridLines = true;
            this.listView1.Location = new System.Drawing.Point(372, 12);
            this.listView1.Name = "listView1";
            this.listView1.Size = new System.Drawing.Size(355, 300);
            this.listView1.TabIndex = 2;
            this.listView1.UseCompatibleStateImageBehavior = false;
            this.listView1.View = System.Windows.Forms.View.Details;
            this.listView1.SelectedIndexChanged += new System.EventHandler(this.listView1_SelectedIndexChanged);
            // 
            // columnHeader1
            // 
            this.columnHeader1.Text = "Фильм";
            this.columnHeader1.Width = 150;
            // 
            // columnHeader2
            // 
            this.columnHeader2.Text = "Жанр";
            // 
            // columnHeader3
            // 
            this.columnHeader3.Text = "Дата выхода";
            this.columnHeader3.Width = 81;
            // 
            // columnHeader4
            // 
            this.columnHeader4.Text = "Страна";
            // 
            // Form1
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.ClientSize = new System.Drawing.Size(740, 441);
            this.Controls.Add(this.listView1);
            this.Controls.Add(this.label1);
            this.Controls.Add(this.treeView1);
            this.Name = "Form1";
            this.Text = "Form1";
            this.ResumeLayout(false);

        }

        #endregion

        private System.Windows.Forms.TreeView treeView1;
        private System.Windows.Forms.Label label1;
        private System.Windows.Forms.ListView listView1;
        private System.Windows.Forms.ColumnHeader columnHeader1;
        private System.Windows.Forms.ColumnHeader columnHeader2;
        private System.Windows.Forms.ColumnHeader columnHeader3;
        private System.Windows.Forms.ColumnHeader columnHeader4;
    }
}

