#include <iostream>
#include <fstream>
using namespace std;
struct Tree
{
	Tree* left;
	Tree* right;
	int num;
	Tree(int n = 0, Tree * l = 0, Tree * r = 0) :num(n), left(l), right(r) {}
};

class BTree
{
	Tree* root;

public:


	BTree()
	{
		ifstream file("file.txt");
		string number;
		

		if (file)
		{
			while (!file.eof())
			{

				file >> number;
				int num=atoi(number.c_str());

				if (root == NULL) {
					root = new Tree(num);

				}
				else {

					if (num < root->num) {
						//cout << "<";
						add(root->left, num);

					}
					else {
						add(root->right, num);
						//cout << ">";
					}
				}


			}
		}
		else
			cout << "File not found" << endl;

		file.close();
	}

	void add(Tree*& t, int n) {
		if (t == NULL) {
			t = new Tree(n);

		}
		else {

			if (n < t->num) {
				//cout << "<";
				add(t->left, n);

			}
			else {
				add(t->right, n);
				//cout << ">";
			}
		}

	}
	void additem(int n) {
		add(root, n);
	}
	void inorder(Tree*& t)
	{
		if (t != NULL) {

			inorder(t->left);
			cout << t->num << " | ";
			inorder(t->right);

		}
		//else cout << "t == NULL";
	}
	
	int cnt, val;
	void findDouble(Tree* t)
	{
		if (t)
		{
			findDouble(t->left);
			if (cnt && (t->num == val))
			{
				++cnt;
				if ((cnt > 1) && (0 == t->right))
				{
					for (int i = 0; i < cnt; ++i)
					{
						std::cout << val << '\n';
					}
					cnt = 1;
				}
			}
			else
			{
				if (cnt > 1)
				{
					for (int i = 0; i < cnt; ++i)
					{
						std::cout << val << '\n';
					}
				}
				val = t->num;
				cnt = 1;
			}
			findDouble(t->right);
		}
	}

	void showtree() {
		inorder(root);
		cout << endl;
		findDouble(root);
	}
};
void main()
{
	
	BTree bt;
	cout << endl;
	bt.showtree();
}