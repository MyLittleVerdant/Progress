#include <iostream>
#include <fstream>
#include <algorithm>
using namespace std;

struct node 
{
	int key;
	int  height;
	node* left;
	node* right;
	
};

class Tree
{
	node* root;
	bool flag=false;
public:
	Tree()
	{
		ifstream file("file.txt");
		string number;


		if (file)
		{
			while (!file.eof())
			{

				file >> number;
				int num = atoi(number.c_str());
				
				root=insert(root, num);
				
				/*if (root == NULL) {
					root = new node;
					root->key = num;
					root->left = root->right = NULL;
					root->height = 0;

				}
				else {

					if (num < root->key) {
						
						root->left=insert(root->left, num);


					}
					else {
						root->right = insert(root->right, num);
						
					}
				}*/


			}
		}
		else
			cout << "File not found" << endl;

		file.close();
	}


	 int height(node* p)
	{
		
		return p ? p->height : -1;
	}


	int bfactor(node* p)
	{
		if (!p->left)
			return height(p->right) + 1;
		else if (!p->right)
			return -1- height(p->left);
		else
		return height(p->right) - height(p->left);
	}


	void fixheight(node* p)
	{
		 int hl = height(p->left);
		 int hr = height(p->right);
		p->height = (hl > hr ? hl : hr) + 1;
	}

	node* rotateright(node* p) // правый поворот вокруг p
	{
		node* q = p->left;
		p->left = q->right;
		q->right = p;
		fixheight(p);
		fixheight(q);
		return q;
	}

	node* rotateleft(node* q) // левый поворот вокруг q
	{
		node* p = q->right;
		q->right = p->left;
		p->left = q;
		fixheight(q);
		fixheight(p);
		return p;
	}

	node* balance(node* p) // балансировка узла p
	{
		fixheight(p);
		if (bfactor(p) == 2)
		{
			if (bfactor(p->right) < 0)
				p->right = rotateright(p->right);
			return rotateleft(p);
		}
		if (bfactor(p) == -2)
		{
			if (bfactor(p->left) > 0)
				p->left = rotateleft(p->left);
			return rotateright(p);
		}
		return p; // балансировка не нужна
	}

	node* insert(node* p, int k) // вставка ключа k в дерево с корнем p
	{
		if (!p)
		{
			p = new node;
			p->key = k;
			p->left = p->right = NULL;
			p->height = 0;
			return p;
		}
		else
		{
			if (k < p->key)
				p->left=insert(p->left, k);
			else
				p->right = insert(p->right, k);
			 return balance(p);
		}
	}

	node* findmin(node* p) // поиск узла с минимальным ключом в дереве p 
	{
		return p->left ? findmin(p->left) : p;
	}

	node* removemin(node* p) // удаление узла с минимальным ключом из дерева p
	{
		if (p->left == 0)
			return p->right;
		p->left = removemin(p->left);
		return balance(p);
	}

	node* remove(node* p, int k) // удаление ключа k из дерева p
	{
		if (!p) return 0;
		if (k < p->key)
			p->left = remove(p->left, k);
		else if (k > p->key)
			p->right = remove(p->right, k);
		else //  k == p->key 
		{
			flag = true;
			node* q = p->left;
			node* r = p->right;
			delete p;
			if (!r) return q;
			node* min = findmin(r);
			min->right = removemin(r);
			min->left = q;
			return balance(min);
		}
		return balance(p);
	}


	void inorder(node* t)
	{
		if (t != NULL) {

			inorder(t->left);
			cout << t->key << " | ";
			inorder(t->right);

		}
		
	}


	void showtree() {
		inorder(root);
		cout << endl;
		
	}
	void Del(int key)
	{

		remove(root, key);
		if (!flag)
			cout << "No such element\n" << endl;
		else flag = false;
	}


};


void main()
{
	Tree AVL;

	string sc;
	int c;
	do {
		AVL.showtree();
		cout<<endl << "Which element do you want to delete?   ";
		cin >> sc;
		if (all_of(begin(sc), end(sc), isdigit));
		{
			c = atoi(sc.c_str());
			AVL.Del(c);
		}
	} while (all_of(begin(sc), end(sc), isdigit));
	
}